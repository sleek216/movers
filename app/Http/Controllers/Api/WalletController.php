<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletReport;
use App\Models\PaymentList;
use App\Services\FirebasePushService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function walletReport(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);

        $reports = WalletReport::where('uid', $uid)->orderBy('id', 'desc')->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Wallet Report Received!',
            'wallet' => (string)($user ? $user->wallet : 0),
            'Walletitem' => $reports
        ]);
    }

    public function walletUp(Request $request)
    {
        $uid = $request->input('uid');
        $amount = (float)$request->input('wallet');

        $user = User::find($uid);
        if ($user) {
            $user->increment('wallet', $amount);

            WalletReport::create([
                'uid' => $uid,
                'message' => 'Wallet Top-Up via Payment Gateway',
                'status' => 'Credit',
                'amt' => $amount,
                'tdate' => now()
            ]);

            // Notify user
            FirebasePushService::notifyUser(
                $uid,
                'Wallet Credited! 💳',
                "Rs. " . number_format($amount, 2) . " credited to your Movers Wallet. Current Balance: Rs. " . number_format($user->wallet, 2),
                ['type' => 'wallet', 'amount' => (string)$amount]
            );

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Wallet Balance Updated Successfully!',
                'wallet' => (string)$user->wallet
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'User Not Found!'
        ]);
    }

    public function paymentGateways(Request $request)
    {
        $gateways = PaymentList::where('status', 1)->get();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Payment Gateways Received!',
            'paymentdata' => $gateways
        ]);
    }
}