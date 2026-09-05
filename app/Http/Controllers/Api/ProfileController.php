<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);

        if ($user) {
            if ($request->filled('name')) {
                $user->name = $request->input('name');
            }
            if ($request->filled('password')) {
                $user->password = $request->input('password');
            }
            if ($request->filled('email')) {
                $user->email = $request->input('email');
            }
            $user->save();

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Profile Updated Successfully!',
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
                    'pro_pic' => $user->pro_pic ?? ''
                ]
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'User Not Found!'
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);

        if ($user) {
            foreach ($request->allFiles() as $key => $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/profile'), $filename);
                    $user->pro_pic = 'images/profile/' . $filename;
                    $user->save();
                    break;
                }
            }

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Profile Picture Updated!',
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
                    'pro_pic' => $user->pro_pic ?? ''
                ]
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'User Not Found!'
        ]);
    }

    public function uploadDocuments(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);

        if ($user) {
            $docDir = public_path('images/doc');
            if (!file_exists($docDir)) {
                mkdir($docDir, 0777, true);
            }

            // Save Document image (CNIC/License)
            if ($request->hasFile('image0')) {
                $file = $request->file('image0');
                if ($file->isValid()) {
                    $filename = 'doc_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move($docDir, $filename);
                    $user->identity_document = 'images/doc/' . $filename;
                }
            }

            // Save Selfie image
            if ($request->hasFile('image1')) {
                $file = $request->file('image1');
                if ($file->isValid()) {
                    $filename = 'selfie_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move($docDir, $filename);
                    $user->selfie = 'images/doc/' . $filename;
                }
            }

            // Handle any other keys
            foreach ($request->allFiles() as $key => $file) {
                if ($file->isValid() && $key !== 'image0' && $key !== 'image1') {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($docDir, $filename);
                    $path = 'images/doc/' . $filename;

                    if (empty($user->selfie) && (str_contains(strtolower($key), 'self') || str_contains(strtolower($key), 'images'))) {
                        $user->selfie = $path;
                    } elseif (empty($user->identity_document)) {
                        $user->identity_document = $path;
                    }
                }
            }

            $user->is_verify = 3; // Under Review
            $user->save();

            return response()->json([
                'ResponseCode' => '200',
                'Result' => 'true',
                'ResponseMsg' => 'Documents Uploaded Successfully for Verification!',
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
                    'identity_document' => $user->identity_document ?? '',
                    'selfie' => $user->selfie ?? '',
                    'is_verify' => (string) $user->is_verify
                ]
            ]);
        }

        return response()->json([
            'ResponseCode' => '401',
            'Result' => 'false',
            'ResponseMsg' => 'User Not Found!'
        ]);
    }

    public function referralData(Request $request)
    {
        $uid = $request->input('uid');
        $user = User::find($uid);
        $settings = Setting::first();

        return response()->json([
            'ResponseCode' => '200',
            'Result' => 'true',
            'ResponseMsg' => 'Referral Data Received!',
            'code' => (string)($user ? $user->code : ''),
            'signupcredit' => (string)($settings ? ($settings->scredit ?? '10') : '10'),
            'refercredit' => (string)($settings ? ($settings->rcredit ?? '50') : '50')
        ]);
    }
}