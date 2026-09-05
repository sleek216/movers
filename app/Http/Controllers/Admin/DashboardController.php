<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBanners = DB::table('banner')->count();
        $totalStates = DB::table('tbl_state')->count();
        $totalUsers = DB::table('tbl_user')->count();
        $totalTransporters = DB::table('tbl_lowner')->count();
        $totalLorries = DB::table('tbl_lorry')->count();
        $totalVehicles = DB::table('tbl_vehicle')->count();
        $totalFaqs = DB::table('tbl_faq')->count();
        $totalCodes = DB::table('tbl_code')->count();

        // Load Booking stats
        $pendingLoads = DB::table('tbl_load')->where('load_status', 'Pending')->count();
        $acceptedLoads = DB::table('tbl_load')->where('load_status', 'Accepted')->count();
        $pickupLoads = DB::table('tbl_load')->where('load_status', 'Pickup')->count();
        $completedLoads = DB::table('tbl_load')->where('load_status', 'Complete')->count();
        $cancelledLoads = DB::table('tbl_load')->where('load_status', 'Cancelled')->count();
        $totalLoads = DB::table('tbl_load')->count();

        // Total earnings calculation
        $totalEarnings = DB::table('tbl_load')
            ->where('load_status', 'Complete')
            ->sum('commission');

        $pendingPayouts = DB::table('payout_setting')
            ->where('status', 'Pending')
            ->sum('amt');

        // Recent Loads
        $recentLoads = DB::table('tbl_load')
            ->leftJoin('tbl_user', 'tbl_load.uid', '=', 'tbl_user.id')
            ->select('tbl_load.*', 'tbl_user.name as user_name', 'tbl_user.mobile as user_mobile')
            ->orderBy('tbl_load.id', 'desc')
            ->limit(8)
            ->get();

        // Recent Transporters
        $recentTransporters = DB::table('tbl_lowner')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $setting = DB::table('tbl_setting')->first();

        return view('admin.dashboard', compact(
            'totalBanners',
            'totalStates',
            'totalUsers',
            'totalTransporters',
            'totalLorries',
            'totalVehicles',
            'totalFaqs',
            'totalCodes',
            'pendingLoads',
            'acceptedLoads',
            'pickupLoads',
            'completedLoads',
            'cancelledLoads',
            'totalLoads',
            'totalEarnings',
            'pendingPayouts',
            'recentLoads',
            'recentTransporters',
            'setting'
        ));
    }
}
