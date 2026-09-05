<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = DB::table('payout_setting')
            ->leftJoin('tbl_lowner', 'payout_setting.owner_id', '=', 'tbl_lowner.id')
            ->select('payout_setting.*', 'tbl_lowner.name as owner_name', 'tbl_lowner.mobile as owner_mobile')
            ->orderBy('payout_setting.id', 'desc')
            ->get();

        return view('admin.payouts.index', compact('payouts'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Completed,Cancelled',
            'proof' => 'nullable|image|max:5120',
        ]);

        $proofPath = '';
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/payout'), $filename);
            $proofPath = 'images/payout/' . $filename;
        }

        $updateData = ['status' => $request->status];
        if ($proofPath) {
            $updateData['proof'] = $proofPath;
        }

        DB::table('payout_setting')->where('id', $id)->update($updateData);

        return back()->with('success', 'Payout status updated successfully.');
    }

    public function earningReport()
    {
        $completedLoads = DB::table('tbl_load')
            ->where('load_status', 'Complete')
            ->leftJoin('tbl_user', 'tbl_load.uid', '=', 'tbl_user.id')
            ->leftJoin('tbl_lowner', 'tbl_load.lorry_owner_id', '=', 'tbl_lowner.id')
            ->select(
                'tbl_load.*',
                'tbl_user.name as customer_name',
                'tbl_lowner.name as transporter_name'
            )
            ->orderBy('tbl_load.id', 'desc')
            ->get();

        $totalEarnings = $completedLoads->sum('commission');
        $totalVolume = $completedLoads->sum('total_amt');

        return view('admin.payouts.earning_report', compact('completedLoads', 'totalEarnings', 'totalVolume'));
    }
}
