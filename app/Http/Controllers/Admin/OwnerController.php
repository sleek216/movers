<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = DB::table('tbl_lowner')->orderBy('id', 'desc')->get();
        return view('admin.owners.index', compact('owners'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $owner = DB::table('tbl_lowner')->where('id', $id)->first();
        if (!$owner) {
            return back()->with('error', 'Transporter not found.');
        }

        $newStatus = $owner->status == 1 ? 0 : 1;
        DB::table('tbl_lowner')->where('id', $id)->update(['status' => $newStatus]);

        return back()->with('success', 'Transporter status updated successfully.');
    }

    public function verifyDocument(Request $request, $id)
    {
        $request->validate([
            'is_verify' => 'required|in:1,2', // 1=Verified/Approved, 2=Rejected
            'reject_comment' => 'nullable|string',
        ]);

        $status = $request->is_verify;
        $comment = $request->reject_comment ?? '';

        DB::table('tbl_lowner')->where('id', $id)->update([
            'is_verify' => $status,
            'reject_comment' => $comment,
        ]);

        // Send notification log if table exists
        $timestamp = now()->format('Y-m-d H:i:s');
        $msg = $status == 1 ? 'Your documents have been approved.' : 'Your documents were rejected: ' . $comment;
        DB::table('tbl_rnoti')->insert([
            'rid' => $id,
            'date' => $timestamp,
            'msg' => $msg,
        ]);

        $msgText = $status == 1 ? 'Transporter documents approved successfully!' : 'Transporter documents rejected.';
        return back()->with('success', $msgText);
    }

    public function updateCommission(Request $request, $id)
    {
        $request->validate([
            'commission' => 'required|numeric|min:0',
        ]);

        DB::table('tbl_lowner')->where('id', $id)->update([
            'commission' => $request->commission,
        ]);

        return back()->with('success', 'Commission rate updated successfully.');
    }
}
