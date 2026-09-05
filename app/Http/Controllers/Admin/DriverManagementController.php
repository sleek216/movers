<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverManagementController extends Controller
{
    /**
     * Display all fleet drivers with transporter owner information
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $transporterId = $request->input('transporter_id', '');

        $query = DB::table('tbl_user_driver')
            ->leftJoin('tbl_user', 'tbl_user_driver.user_id', '=', 'tbl_user.id')
            ->select(
                'tbl_user_driver.*',
                'tbl_user.name as transporter_name',
                'tbl_user.mobile as transporter_mobile',
                'tbl_user.email as transporter_email'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tbl_user_driver.name', 'like', "%{$search}%")
                  ->orWhere('tbl_user_driver.phone', 'like', "%{$search}%")
                  ->orWhere('tbl_user_driver.primary_route', 'like', "%{$search}%")
                  ->orWhere('tbl_user.name', 'like', "%{$search}%");
            });
        }

        if (!empty($transporterId)) {
            $query->where('tbl_user_driver.user_id', $transporterId);
        }

        $drivers = $query->orderBy('tbl_user_driver.id', 'desc')->paginate(15);

        // Stats
        $totalDrivers = DB::table('tbl_user_driver')->count();
        $activeDrivers = DB::table('tbl_user_driver')->where('status', 'active')->count();
        $totalTransporters = DB::table('tbl_user_driver')->distinct('user_id')->count('user_id');

        // All transporters for dropdown
        $transporters = DB::table('tbl_user')
            ->where('status', 1)
            ->select('id', 'name', 'mobile')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.drivers.index', compact(
            'drivers',
            'totalDrivers',
            'activeDrivers',
            'totalTransporters',
            'transporters',
            'search',
            'transporterId'
        ));
    }

    /**
     * Store a new driver from Admin Panel
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'primary_route' => 'required|string|max:200',
            'photo' => 'nullable|image|max:3072',
        ]);

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
        DB::table('tbl_user_driver')->insert([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'vehicle_type' => 'General Vehicle',
            'vehicle_number' => '',
            'primary_route' => $request->primary_route,
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return back()->with('success', 'New fleet driver added successfully!');
    }

    /**
     * Update driver details from Admin Panel
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'phone' => 'required|string|max:50',
            'primary_route' => 'required|string|max:200',
            'photo' => 'nullable|image|max:3072',
        ]);

        $driver = DB::table('tbl_user_driver')->where('id', $id)->first();
        if (!$driver) {
            return back()->with('error', 'Driver not found.');
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
        DB::table('tbl_user_driver')->where('id', $id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'primary_route' => $request->primary_route,
            'updated_at' => $now,
        ]);

        return back()->with('success', 'Driver details updated successfully!');
    }

    /**
     * Delete driver from Admin Panel
     */
    public function destroy($id)
    {
        $driver = DB::table('tbl_user_driver')->where('id', $id)->first();
        if (!$driver) {
            return back()->with('error', 'Driver not found.');
        }

        // Delete photo if exists
        if (!empty($driver->photo) && file_exists(public_path($driver->photo))) {
            @unlink(public_path($driver->photo));
        }

        DB::table('tbl_user_driver')->where('id', $id)->delete();

        return back()->with('success', 'Driver removed from directory successfully!');
    }
}
