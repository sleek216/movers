<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LorryController extends Controller
{
    public function index()
    {
        $lorries = DB::table('tbl_lorry')
            ->leftJoin('tbl_lowner', 'tbl_lorry.owner_id', '=', 'tbl_lowner.id')
            ->leftJoin('tbl_vehicle', 'tbl_lorry.vehicle_id', '=', 'tbl_vehicle.id')
            ->select(
                'tbl_lorry.*',
                'tbl_lowner.name as owner_name',
                'tbl_lowner.mobile as owner_mobile',
                'tbl_vehicle.title as vehicle_title',
                'tbl_vehicle.img as vehicle_img'
            )
            ->orderBy('tbl_lorry.id', 'desc')
            ->get();

        return view('admin.lorries.index', compact('lorries'));
    }

    public function show($id)
    {
        $lorry = DB::table('tbl_lorry')
            ->leftJoin('tbl_lowner', 'tbl_lorry.owner_id', '=', 'tbl_lowner.id')
            ->leftJoin('tbl_vehicle', 'tbl_lorry.vehicle_id', '=', 'tbl_vehicle.id')
            ->leftJoin('tbl_state', 'tbl_lorry.curr_state_id', '=', 'tbl_state.id')
            ->select(
                'tbl_lorry.*',
                'tbl_lowner.name as owner_name',
                'tbl_lowner.email as owner_email',
                'tbl_lowner.mobile as owner_mobile',
                'tbl_vehicle.title as vehicle_title',
                'tbl_state.title as state_title'
            )
            ->where('tbl_lorry.id', $id)
            ->first();

        if (!$lorry) {
            return redirect()->route('admin.lorries.index')->with('error', 'Lorry not found.');
        }

        return view('admin.lorries.show', compact('lorry'));
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'is_verify' => 'required|in:1,2',
            'cancle_reason' => 'nullable|string',
        ]);

        DB::table('tbl_lorry')->where('id', $id)->update([
            'is_verify' => $request->is_verify,
            'cancle_reason' => $request->cancle_reason ?? '',
        ]);

        $msg = $request->is_verify == 1 ? 'Lorry approved successfully!' : 'Lorry rejected.';
        return back()->with('success', $msg);
    }

    public function toggleStatus(Request $request, $id)
    {
        $lorry = DB::table('tbl_lorry')->where('id', $id)->first();
        if (!$lorry) {
            return back()->with('error', 'Lorry not found.');
        }

        $newStatus = $lorry->status == 1 ? 0 : 1;
        DB::table('tbl_lorry')->where('id', $id)->update(['status' => $newStatus]);

        return back()->with('success', 'Lorry status updated successfully.');
    }
}
