<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_user')) {
            return redirect()->route('admin.dashboard');
        }
        $setting = DB::table('tbl_setting')->first();
        return view('admin.auth.login', compact('setting'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admin')
            ->where('username', $request->username)
            ->where('password', $request->password)
            ->first();

        if ($admin) {
            session([
                'admin_user' => $admin->username,
                'admin_id' => $admin->id,
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'ResponseCode' => '200',
                    'Result' => 'true',
                    'title' => 'Login Successful!',
                    'message' => 'Welcome Admin',
                    'action' => route('admin.dashboard'),
                ]);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        if ($request->ajax()) {
            return response()->json([
                'ResponseCode' => '400',
                'Result' => 'false',
                'title' => 'Invalid Credentials!',
                'message' => 'Please enter correct username and password.',
            ]);
        }

        return back()->with('error', 'Invalid username or password.')->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_user', 'admin_id']);
        session()->flush();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
