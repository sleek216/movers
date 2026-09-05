<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $setting = DB::table('tbl_setting')->first();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = DB::table('tbl_setting')->first();

        $logoPath = $setting ? $setting->weblogo : '';
        if ($request->hasFile('weblogo')) {
            $file = $request->file('weblogo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $logoPath = 'images/' . $filename;
        }

        $data = [
            'webname' => $request->webname ?? ($setting->webname ?? 'Movers Freight'),
            'weblogo' => $logoPath,
            'timezone' => $request->timezone ?? ($setting->timezone ?? 'Asia/Kolkata'),
            'currency' => $request->currency ?? ($setting->currency ?? '$'),
            'pstore' => $request->pstore ?? ($setting->pstore ?? ''),
            'one_key' => $request->one_key ?? ($setting->one_key ?? ''),
            'one_hash' => $request->one_hash ?? ($setting->one_hash ?? ''),
            'd_key' => $request->d_key ?? ($setting->d_key ?? ''),
            'd_hash' => $request->d_hash ?? ($setting->d_hash ?? ''),
            'scredit' => $request->scredit ?? ($setting->scredit ?? '0'),
            'rcredit' => $request->rcredit ?? ($setting->rcredit ?? '0'),
            'sms_type' => $request->sms_type ?? ($setting->sms_type ?? '0'),
            'auth_key' => $request->auth_key ?? ($setting->auth_key ?? ''),
            'otp_id' => $request->otp_id ?? ($setting->otp_id ?? ''),
            'acc_id' => $request->acc_id ?? ($setting->acc_id ?? ''),
            'auth_token' => $request->auth_token ?? ($setting->auth_token ?? ''),
            'twilio_number' => $request->twilio_number ?? ($setting->twilio_number ?? ''),
            'otp_auth' => $request->otp_auth ?? ($setting->otp_auth ?? 'No'),
            'ai_provider' => $request->ai_provider ?? ($setting->ai_provider ?? 'gemini'),
            'gemini_api_key' => $request->gemini_api_key ?? ($setting->gemini_api_key ?? ''),
            'openai_api_key' => $request->openai_api_key ?? ($setting->openai_api_key ?? ''),
            'google_map_key' => $request->google_map_key ?? ($setting->google_map_key ?? ''),
        ];

        if ($setting) {
            DB::table('tbl_setting')->where('id', $setting->id)->update($data);
        } else {
            DB::table('tbl_setting')->insert($data);
        }

        return back()->with('success', 'General and API settings updated successfully!');
    }

    public function profile()
    {
        $admin = DB::table('admin')->where('username', session('admin_user'))->first();
        return view('admin.settings.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:4',
        ]);

        DB::table('admin')->where('id', session('admin_id'))->update([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        session(['admin_user' => $request->username]);

        return back()->with('success', 'Admin credentials updated successfully!');
    }
}
