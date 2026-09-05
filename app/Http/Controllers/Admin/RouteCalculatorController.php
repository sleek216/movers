<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteCalculatorController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('status', 1)->orderBy('id')->get();
        $setting = DB::table('tbl_setting')->first();
        $dieselPrice = $setting->diesel_price ?? 275.00;

        return view('admin.calculator.index', compact('vehicles', 'dieselPrice'));
    }

    public function update(Request $request)
    {
        // Update Diesel Price in settings
        if ($request->has('diesel_price')) {
            DB::table('tbl_setting')->update([
                'diesel_price' => $request->input('diesel_price', 275.00),
            ]);
        }

        // Update Vehicle Rates
        if ($request->has('vehicles') && is_array($request->vehicles)) {
            foreach ($request->vehicles as $vId => $rates) {
                Vehicle::where('id', $vId)->update([
                    'base_fare' => $rates['base_fare'] ?? 2000.00,
                    'per_km_rate' => $rates['per_km_rate'] ?? 95.00,
                    'toll_rate_per_km' => $rates['toll_rate_per_km'] ?? 5.00,
                    'fuel_average' => $rates['fuel_average'] ?? 6.00,
                ]);
            }
        }

        return redirect()->route('admin.calculator.index')->with('success', 'Route Calculator & Vehicle Rates updated successfully!');
    }
}
