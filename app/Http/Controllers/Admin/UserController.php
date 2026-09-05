<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('tbl_user')->orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(Request $request, $id)
    {
        $user = DB::table('tbl_user')->where('id', $id)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $newStatus = $user->status == 1 ? 0 : 1;
        DB::table('tbl_user')->where('id', $id)->update(['status' => $newStatus]);

        if ($request->ajax()) {
            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'title' => 'Status Updated!',
                'message' => 'User status changed successfully.',
            ]);
        }

        return back()->with('success', 'User status updated successfully.');
    }

    public function verifyDocument(Request $request, $id)
    {
        $request->validate([
            'is_verify' => 'required|in:1,2', // 1=Verified/Approved, 2=Rejected
            'reject_comment' => 'nullable|string',
        ]);

        $status = $request->is_verify;
        $comment = $request->reject_comment ?? '';

        DB::table('tbl_user')->where('id', $id)->update([
            'is_verify' => $status,
            'reject_comment' => $comment,
        ]);

        $title = $status == 1 ? 'KYC Verification Approved 🎉' : 'KYC Verification Update ⚠️';
        $description = $status == 1
            ? 'Mubarak ho! Your identity documents have been approved by Movers Admin. Full features unlocked.'
            : 'Your identity documents were rejected. Reason: ' . ($comment ?: 'Incomplete or unclear photos. Please re-upload.');

        \App\Services\FirebasePushService::notifyUser($id, $title, $description, ['type' => 'kyc_status', 'status' => (string)$status]);

        $msg = $status == 1 ? 'User document approved successfully!' : 'User document rejected.';
        return back()->with('success', $msg);
    }

    public function wallet(Request $request, $id)
    {
        $user = DB::table('tbl_user')->where('id', $id)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $transactions = DB::table('wallet_report')
            ->where('uid', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.users.wallet', compact('user', 'transactions'));
    }

    public function adjustWallet(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:Credit,Debit',
            'amount' => 'required|numeric|min:1',
            'message' => 'required|string',
        ]);

        $user = DB::table('tbl_user')->where('id', $id)->first();
        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $currentWallet = (float) $user->wallet;
        $amount = (float) $request->amount;

        if ($request->type === 'Credit') {
            $newWallet = $currentWallet + $amount;
        } else {
            if ($currentWallet < $amount) {
                return back()->with('error', 'Insufficient user wallet balance.');
            }
            $newWallet = $currentWallet - $amount;
        }

        DB::table('tbl_user')->where('id', $id)->update(['wallet' => $newWallet]);

        DB::table('wallet_report')->insert([
            'uid' => $id,
            'message' => $request->message . ' (By Admin)',
            'status' => $request->type,
            'amt' => $amount,
            'tdate' => now()->format('Y-m-d H:i:s'),
        ]);

        $notifTitle = $request->type === 'Credit' ? 'Wallet Credited by Admin 💰' : 'Wallet Debited by Admin 💸';
        $notifMsg = "Rs. " . number_format($amount, 2) . " has been {$request->type}ed to your account. Note: {$request->message}. Balance: Rs. " . number_format($newWallet, 2);
        \App\Services\FirebasePushService::notifyUser($id, $notifTitle, $notifMsg, ['type' => 'wallet']);

        return back()->with('success', 'User wallet updated successfully.');
    }
}
