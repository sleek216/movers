<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use App\Models\WalletReport;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $ccode = $request->input('ccode');
        $password = $request->input('password');
        $refercode = $request->input('refercode');

        if (!$name || !$email || !$mobile || !$password) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Missing Required Fields!'
            ]);
        }

        $existing = User::where('email', $email)->orWhere('mobile', $mobile)->first();
        if ($existing) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Email Or Mobile Already Registered!'
            ]);
        }

        $settings = Setting::first();
        $code = (string) rand(100000, 999999);
        $walletBonus = 0;

        if ($refercode) {
            $parent = User::where('code', $refercode)->first();
            if ($parent && $settings) {
                $walletBonus = (float)($settings->scredit ?? 0);
                $parentBonus = (float)($settings->rcredit ?? 0);
                $parent->increment('wallet', $parentBonus);

                WalletReport::create([
                    'uid' => $parent->id,
                    'message' => 'Referral Bonus for inviting ' . $name,
                    'status' => 'Credit',
                    'amt' => $parentBonus,
                    'tdate' => now()->format('Y-m-d H:i:s')
                ]);
            }
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'ccode' => $ccode ?? '+92',
            'password' => $password,
            'code' => $code,
            'refercode' => $refercode ?: '0',
            'wallet' => (string) $walletBonus,
            'rdate' => now()->format('Y-m-d H:i:s'),
            'status' => 1,
            'is_verify' => 0
        ]);

        if ($walletBonus > 0) {
            WalletReport::create([
                'uid' => $user->id,
                'message' => 'Signup Referral Welcome Bonus',
                'status' => 'Credit',
                'amt' => $walletBonus,
                'tdate' => now()->format('Y-m-d H:i:s')
            ]);
        }

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Register Successful!',
            'UserLogin' => [
                'id' => (string) $user->id,
                'name' => (string) $user->name,
                'email' => (string) $user->email,
                'mobile' => (string) $user->mobile,
                'ccode' => (string) $user->ccode,
                'password' => (string) $user->password,
                'code' => (string) $user->code,
                'refercode' => (string) $user->refercode,
                'wallet' => (string) $user->wallet,
                'rdate' => (string) $user->rdate,
                'status' => (string) $user->status,
                'pro_pic' => $user->pro_pic ?? '',
                'is_verify' => (string) ($user->is_verify ?? '0'),
            ]
        ]);
    }

    public function login(Request $request)
    {
        $mobile = $request->input('mobile');
        $ccode = $request->input('ccode');
        $password = $request->input('password');

        $user = User::where('mobile', $mobile)->where('password', $password)->first();

        if ($user) {
            if ($user->status != 1) {
                return response()->json([
                    'ResponseCode' => '401',
                    'Result' => 'false',
                    'ResponseMsg' => 'Account is deactivated by admin!'
                ]);
            }

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Login Successful!',
                'UserLogin' => [
                    'id' => (string) $user->id,
                    'name' => (string) $user->name,
                    'email' => (string) $user->email,
                    'mobile' => (string) $user->mobile,
                    'ccode' => (string) $user->ccode,
                    'password' => (string) $user->password,
                    'code' => (string) $user->code,
                    'refercode' => (string) $user->refercode,
                    'wallet' => (string) $user->wallet,
                    'rdate' => (string) $user->rdate,
                    'status' => (string) $user->status,
                    'pro_pic' => $user->pro_pic ?? '',
                    'is_verify' => (string) ($user->is_verify ?? '0'),
                ]
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Invalid Mobile Number Or Password!'
        ]);
    }

    public function mobileCheck(Request $request)
    {
        $mobile = $request->input('mobile');
        $ccode = $request->input('ccode');

        $exists = User::where('mobile', $mobile)->exists();
        if ($exists) {
            return response()->json([
                'ResponseCode' => '401',
                'Result' => 'false',
                'ResponseMsg' => 'Mobile Number Already Registered!'
            ]);
        }

        $settings = Setting::first();
        $otpAuth = $settings ? ($settings->otp_auth ?? 'No') : 'No';
        $otp = rand(100000, 999999);

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Mobile Number Available!',
            'otp_auth' => $otpAuth,
            'otp' => $otp
        ]);
    }

    public function sendOtp(Request $request)
    {
        $mobile = $request->input('mobile');
        $settings = Setting::first();
        $otpAuth = $settings ? ($settings->otp_auth ?? 'No') : 'No';
        $otp = rand(100000, 999999);

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'OTP Sent Successfully!',
            'otp' => $otp,
            'otp_auth' => $otpAuth
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $mobile = $request->input('mobile');
        $password = $request->input('password');

        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            $user->password = $password;
            $user->save();

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Password Reset Successfully!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Mobile Number Not Found!'
        ]);
    }

    public function updateFcm(Request $request)
    {
        $uid = $request->input('uid');
        $fcmToken = $request->input('fcm_token');

        if ($uid && $fcmToken) {
            User::where('id', $uid)->update(['fcm_token' => $fcmToken]);
            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'FCM Token Updated!'
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'Missing UID or FCM Token'
        ]);
    }
}