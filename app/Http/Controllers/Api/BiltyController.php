<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bilty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BiltyController extends Controller
{
    /**
     * Create a new Digital Bilty with Driver & Guarantor Verification
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'consignor_name' => 'required|string|max:255',
            'consignor_city' => 'required|string|max:100',
            'consignee_name' => 'required|string|max:255',
            'consignee_city' => 'required|string|max:100',
            'goods_description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ResponseCode' => '400',
                'Result' => 'false',
                'ResponseMsg' => $validator->errors()->first()
            ], 400);
        }

        try {
            // Auto-generate sequential Bilty Number: e.g. BLT-2026-0001
            $lastBilty = Bilty::orderBy('id', 'desc')->first();
            $nextNumber = $lastBilty ? ($lastBilty->id + 1) : 1;
            $biltyNumber = 'BLT-' . date('Y') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // File Upload Helper
            $uploadPath = public_path('uploads/bilties');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $driverCnicFront = $this->handleFileUpload($request, 'driver_cnic_front', 'cnic_f_');
            $driverCnicBack = $this->handleFileUpload($request, 'driver_cnic_back', 'cnic_b_');
            $driverLicense = $this->handleFileUpload($request, 'driver_license', 'lic_');
            $driverPhoto = $this->handleFileUpload($request, 'driver_photo', 'drv_');
            $truckBookPhoto = $this->handleFileUpload($request, 'truck_book_photo', 'trk_');
            $guarantorCnicPhoto = $this->handleFileUpload($request, 'guarantor_cnic_photo', 'grt_');

            $freightTotal = (float) $request->input('freight_total', 0);
            $advancePaid = (float) $request->input('advance_paid', 0);
            $balanceAmount = $freightTotal - $advancePaid;

            $bilty = Bilty::create([
                'uid' => $request->input('uid'),
                'bilty_number' => $request->input('custom_bilty_number') ?: $biltyNumber,
                'bilty_date' => $request->input('bilty_date') ?: date('Y-m-d'),
                
                // Consignor (Sender)
                'consignor_name' => $request->input('consignor_name'),
                'consignor_phone' => $request->input('consignor_phone'),
                'consignor_city' => $request->input('consignor_city'),
                'consignor_address' => $request->input('consignor_address'),
                
                // Consignee (Receiver)
                'consignee_name' => $request->input('consignee_name'),
                'consignee_phone' => $request->input('consignee_phone'),
                'consignee_city' => $request->input('consignee_city'),
                'consignee_address' => $request->input('consignee_address'),
                
                // Cargo
                'goods_description' => $request->input('goods_description'),
                'package_type' => $request->input('package_type', 'Nag / Bori'),
                'total_packages' => (int) $request->input('total_packages', 1),
                'weight_value' => (float) $request->input('weight_value', 0),
                'weight_unit' => $request->input('weight_unit', 'KG'),
                
                // Freight & Payment
                'freight_total' => $freightTotal,
                'advance_paid' => $advancePaid,
                'balance_amount' => $balanceAmount >= 0 ? $balanceAmount : 0,
                'loading_charges' => (float) $request->input('loading_charges', 0),
                'payment_status' => $request->input('payment_status', 'To-Pay'),
                
                // Driver KYC Verification
                'driver_name' => $request->input('driver_name'),
                'driver_phone' => $request->input('driver_phone'),
                'driver_cnic' => $request->input('driver_cnic'),
                'driver_cnic_front' => $driverCnicFront,
                'driver_cnic_back' => $driverCnicBack,
                'driver_license' => $driverLicense,
                'driver_photo' => $driverPhoto,
                'truck_number' => $request->input('truck_number'),
                'truck_type' => $request->input('truck_type'),
                'truck_book_photo' => $truckBookPhoto,
                
                // Guarantor (Zamanatdar) Verification
                'guarantor_name' => $request->input('guarantor_name'),
                'guarantor_phone' => $request->input('guarantor_phone'),
                'guarantor_cnic' => $request->input('guarantor_cnic'),
                'guarantor_cnic_photo' => $guarantorCnicPhoto,
                'guarantor_relation' => $request->input('guarantor_relation'),
                'guarantor_note' => $request->input('guarantor_note'),
                
                // Status
                'status' => 'Booked',
                'remarks' => $request->input('remarks'),
            ]);

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Digital Bilty Created Successfully!',
                'bilty' => $this->formatBiltyResponse($bilty)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ResponseCode' => '500',
                'Result' => 'false',
                'ResponseMsg' => 'Failed to create bilty: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List user's or adda's bilties with search & filters
     */
    public function list(Request $request)
    {
        $query = Bilty::query();

        if ($request->filled('uid')) {
            $query->where('uid', $request->input('uid'));
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('bilty_number', 'LIKE', "%$s%")
                  ->orWhere('consignor_name', 'LIKE', "%$s%")
                  ->orWhere('consignee_name', 'LIKE', "%$s%")
                  ->orWhere('consignor_city', 'LIKE', "%$s%")
                  ->orWhere('consignee_city', 'LIKE', "%$s%")
                  ->orWhere('driver_name', 'LIKE', "%$s%")
                  ->orWhere('truck_number', 'LIKE', "%$s%")
                  ->orWhere('driver_phone', 'LIKE', "%$s%");
            });
        }

        $bilties = $query->orderBy('id', 'desc')->paginate(30);

        $formatted = collect($bilties->items())->map(function ($b) {
            return $this->formatBiltyResponse($b);
        });

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Bilty list received',
            'total_count' => $bilties->total(),
            'bilties' => $formatted
        ]);
    }

    /**
     * Get single bilty details
     */
    public function details($id)
    {
        $bilty = Bilty::where('id', $id)->orWhere('bilty_number', $id)->first();
        if (!$bilty) {
            return response()->json([
                'ResponseCode' => '404',
                'Result' => 'false',
                'ResponseMsg' => 'Bilty not found'
            ], 404);
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Bilty details received',
            'bilty' => $this->formatBiltyResponse($bilty)
        ]);
    }

    /**
     * Update delivery status
     */
    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        $bilty = Bilty::find($id);
        if (!$bilty) {
            return response()->json([
                'ResponseCode' => '404',
                'Result' => 'false',
                'ResponseMsg' => 'Bilty not found'
            ], 404);
        }

        $bilty->status = $status;
        $bilty->save();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Bilty status updated to ' . $status,
            'bilty' => $this->formatBiltyResponse($bilty)
        ]);
    }

    /**
     * File upload helper
     */
    private function handleFileUpload(Request $request, $key, $prefix)
    {
        if ($request->hasFile($key)) {
            $file = $request->file($key);
            $filename = $prefix . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bilties'), $filename);
            return 'uploads/bilties/' . $filename;
        }
        return null;
    }

    /**
     * Format Bilty JSON with full image URLs
     */
    private function formatBiltyResponse($bilty)
    {
        $data = $bilty->toArray();
        $baseUrl = url('/') . '/';

        $imageFields = [
            'driver_cnic_front',
            'driver_cnic_back',
            'driver_license',
            'driver_photo',
            'truck_book_photo',
            'guarantor_cnic_photo'
        ];

        foreach ($imageFields as $field) {
            if (!empty($data[$field])) {
                $data[$field . '_url'] = $baseUrl . $data[$field];
            } else {
                $data[$field . '_url'] = null;
            }
        }

        return $data;
    }
}
