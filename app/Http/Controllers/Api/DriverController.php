<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DriverController extends Controller
{
    /**
     * List all drivers belonging to a user/transporter with smart search
     */
    public function list(Request $request)
    {
        $uid = $request->input('uid', 0);
        $search = trim($request->input('search', ''));
        $status = trim($request->input('status', ''));

        if (empty($uid)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'User ID is required',
                'Drivers' => [],
            ]);
        }

        // Security: Enforce KYC verification
        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user || (string)($user->is_verify ?? '0') !== '1') {
            return response()->json([
                'ResponseCode' => '403',
                'Result' => 'false',
                'ResponseMsg' => 'KYC verification required to access driver directory',
                'is_verify' => $user ? (string)($user->is_verify ?? '0') : '0',
                'Drivers' => [],
            ]);
        }

        $query = DB::table('tbl_user_driver')
            ->where('user_id', $uid);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('vehicle_type', 'like', "%{$search}%")
                  ->orWhere('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('primary_route', 'like', "%{$search}%")
                  ->orWhere('cnic', 'like', "%{$search}%");
            });
        }

        if (!empty($status) && $status !== 'All') {
            $query->where('status', strtolower($status));
        }

        $drivers = $query->orderBy('id', 'desc')->get();

        $formattedList = [];
        foreach ($drivers as $driver) {
            $formattedList[] = [
                'id' => (string) $driver->id,
                'user_id' => (string) $driver->user_id,
                'name' => (string) $driver->name,
                'phone' => (string) $driver->phone,
                'photo' => (string) ($driver->photo ?? ''),
                'vehicle_type' => (string) ($driver->vehicle_type ?? 'Truck'),
                'vehicle_number' => (string) ($driver->vehicle_number ?? ''),
                'primary_route' => (string) ($driver->primary_route ?? 'General Routes'),
                'cnic' => (string) ($driver->cnic ?? ''),
                'license_number' => (string) ($driver->license_number ?? ''),
                'experience_years' => (string) ($driver->experience_years ?? ''),
                'status' => (string) ($driver->status ?? 'active'),
                'created_at' => (string) $driver->created_at,
            ];
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Drivers retrieved successfully',
            'Drivers' => $formattedList,
        ]);
    }

    /**
     * Add a new driver with photo upload
     */
    public function add(Request $request)
    {
        $uid = $request->input('uid');
        $name = trim($request->input('name', ''));
        $phone = trim($request->input('phone', ''));
        $vehicleType = trim($request->input('vehicle_type', ''));
        $vehicleNumber = trim($request->input('vehicle_number', ''));
        $primaryRoute = trim($request->input('primary_route', ''));
        $cnic = trim($request->input('cnic', ''));
        $licenseNumber = trim($request->input('license_number', ''));
        $experienceYears = trim($request->input('experience_years', ''));
        $status = strtolower(trim($request->input('status', 'active')));

        if (empty($uid) || empty($name) || empty($phone)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'User ID, Driver Name, and Phone Number are required',
            ]);
        }

        // Security: Enforce KYC verification
        $user = DB::table('tbl_user')->where('id', $uid)->first();
        if (!$user || (string)($user->is_verify ?? '0') !== '1') {
            return response()->json([
                'ResponseCode' => '403',
                'Result' => 'false',
                'ResponseMsg' => 'KYC verification required to add drivers to your fleet',
            ]);
        }

        $photoPath = '';
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'driver_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/drivers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);
            $photoPath = 'images/drivers/' . $fileName;
        }

        $now = now();
        $driverId = DB::table('tbl_user_driver')->insertGetId([
            'user_id' => $uid,
            'name' => $name,
            'phone' => $phone,
            'photo' => $photoPath,
            'vehicle_type' => $vehicleType,
            'vehicle_number' => $vehicleNumber,
            'primary_route' => $primaryRoute,
            'cnic' => $cnic,
            'license_number' => $licenseNumber,
            'experience_years' => $experienceYears,
            'status' => $status,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $createdDriver = [
            'id' => (string) $driverId,
            'user_id' => (string) $uid,
            'name' => $name,
            'phone' => $phone,
            'photo' => $photoPath,
            'vehicle_type' => $vehicleType,
            'vehicle_number' => $vehicleNumber,
            'primary_route' => $primaryRoute,
            'cnic' => $cnic,
            'license_number' => $licenseNumber,
            'experience_years' => $experienceYears,
            'status' => $status,
            'created_at' => (string) $now,
        ];

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Driver added successfully to your fleet',
            'Driver' => $createdDriver,
        ]);
    }

    /**
     * Update an existing driver
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $uid = $request->input('uid');
        $name = trim($request->input('name', ''));
        $phone = trim($request->input('phone', ''));
        $vehicleType = trim($request->input('vehicle_type', ''));
        $vehicleNumber = trim($request->input('vehicle_number', ''));
        $primaryRoute = trim($request->input('primary_route', ''));
        $cnic = trim($request->input('cnic', ''));
        $licenseNumber = trim($request->input('license_number', ''));
        $experienceYears = trim($request->input('experience_years', ''));
        $status = strtolower(trim($request->input('status', 'active')));

        if (empty($id) || empty($uid) || empty($name) || empty($phone)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Driver ID, User ID, Name, and Phone are required',
            ]);
        }

        $driver = DB::table('tbl_user_driver')
            ->where('id', $id)
            ->where('user_id', $uid)
            ->first();

        if (!$driver) {
            return response()->json([
                'ResponseCode' => '404',
                'Result' => 'false',
                'ResponseMsg' => 'Driver not found in your directory',
            ]);
        }

        $photoPath = $driver->photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = 'driver_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('images/drivers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);
            $photoPath = 'images/drivers/' . $fileName;
        }

        $now = now();
        DB::table('tbl_user_driver')
            ->where('id', $id)
            ->where('user_id', $uid)
            ->update([
                'name' => $name,
                'phone' => $phone,
                'photo' => $photoPath,
                'vehicle_type' => $vehicleType,
                'vehicle_number' => $vehicleNumber,
                'primary_route' => $primaryRoute,
                'cnic' => $cnic,
                'license_number' => $licenseNumber,
                'experience_years' => $experienceYears,
                'status' => $status,
                'updated_at' => $now,
            ]);

        $updatedDriver = [
            'id' => (string) $id,
            'user_id' => (string) $uid,
            'name' => $name,
            'phone' => $phone,
            'photo' => $photoPath,
            'vehicle_type' => $vehicleType,
            'vehicle_number' => $vehicleNumber,
            'primary_route' => $primaryRoute,
            'cnic' => $cnic,
            'license_number' => $licenseNumber,
            'experience_years' => $experienceYears,
            'status' => $status,
            'created_at' => (string) $driver->created_at,
        ];

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Driver details updated successfully',
            'Driver' => $updatedDriver,
        ]);
    }

    /**
     * Delete driver from directory
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $uid = $request->input('uid');

        if (empty($id) || empty($uid)) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Driver ID and User ID are required',
            ]);
        }

        $deleted = DB::table('tbl_user_driver')
            ->where('id', $id)
            ->where('user_id', $uid)
            ->delete();

        if ($deleted) {
            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Driver removed from your directory successfully',
            ]);
        }

        return response()->json([
            'ResponseCode' => '404',
            'Result' => 'false',
            'ResponseMsg' => 'Driver not found or already deleted',
        ]);
    }
}
