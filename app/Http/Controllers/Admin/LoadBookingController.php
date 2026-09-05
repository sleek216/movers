<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadBookingController extends Controller
{
    public function index(Request $request, $status = null)
    {
        $query = DB::table('tbl_load')
            ->leftJoin('tbl_user', 'tbl_load.uid', '=', 'tbl_user.id')
            ->leftJoin('tbl_vehicle', 'tbl_load.vehicle_id', '=', 'tbl_vehicle.id')
            ->leftJoin('tbl_lowner', 'tbl_load.lorry_owner_id', '=', 'tbl_lowner.id')
            ->select(
                'tbl_load.*',
                'tbl_user.name as customer_name',
                'tbl_user.mobile as customer_mobile',
                'tbl_vehicle.title as vehicle_title',
                'tbl_lowner.name as transporter_name'
            );

        if ($status && in_array($status, ['Pending', 'Accepted', 'Pickup', 'Complete', 'Cancelled'])) {
            $query->where('tbl_load.load_status', $status);
        }

        $loads = $query->orderBy('tbl_load.id', 'desc')->get();
        $currentStatus = $status ?? 'All';

        return view('admin.loads.index', compact('loads', 'currentStatus'));
    }

    public function show($id)
    {
        $load = DB::table('tbl_load')
            ->leftJoin('tbl_user', 'tbl_load.uid', '=', 'tbl_user.id')
            ->leftJoin('tbl_vehicle', 'tbl_load.vehicle_id', '=', 'tbl_vehicle.id')
            ->leftJoin('tbl_lowner', 'tbl_load.lorry_owner_id', '=', 'tbl_lowner.id')
            ->leftJoin('tbl_lorry', 'tbl_load.lorry_id', '=', 'tbl_lorry.id')
            ->select(
                'tbl_load.*',
                'tbl_user.name as customer_name',
                'tbl_user.mobile as customer_mobile',
                'tbl_user.email as customer_email',
                'tbl_vehicle.title as vehicle_title',
                'tbl_lowner.name as transporter_name',
                'tbl_lowner.mobile as transporter_mobile',
                'tbl_lorry.lorry_no'
            )
            ->where('tbl_load.id', $id)
            ->first();

        if (!$load) {
            return redirect()->route('admin.loads.index')->with('error', 'Load booking not found.');
        }

        // Fetch Bids / Responses
        $bids = DB::table('tbl_load_response')
            ->leftJoin('tbl_lowner', 'tbl_load_response.owner_id', '=', 'tbl_lowner.id')
            ->leftJoin('tbl_lorry', 'tbl_load_response.lorry_id', '=', 'tbl_lorry.id')
            ->select(
                'tbl_load_response.*',
                'tbl_lowner.name as owner_name',
                'tbl_lowner.mobile as owner_mobile',
                'tbl_lorry.lorry_no'
            )
            ->where('tbl_load_response.load_id', $id)
            ->orderBy('tbl_load_response.id', 'desc')
            ->get();

        return view('admin.loads.show', compact('load', 'bids'));
    }
}
