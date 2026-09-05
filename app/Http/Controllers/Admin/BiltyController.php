<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bilty;
use Illuminate\Http\Request;

class BiltyController extends Controller
{
    public function index(Request $request)
    {
        $query = Bilty::query();

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $s = trim($request->input('search'));
            $query->where(function ($q) use ($s) {
                $q->where('bilty_number', 'LIKE', "%$s%")
                  ->orWhere('consignor_name', 'LIKE', "%$s%")
                  ->orWhere('consignee_name', 'LIKE', "%$s%")
                  ->orWhere('consignor_city', 'LIKE', "%$s%")
                  ->orWhere('consignee_city', 'LIKE', "%$s%")
                  ->orWhere('driver_name', 'LIKE', "%$s%")
                  ->orWhere('truck_number', 'LIKE', "%$s%")
                  ->orWhere('driver_cnic', 'LIKE', "%$s%");
            });
        }

        $bilties = $query->orderBy('id', 'desc')->paginate(20);
        $totalCount = Bilty::count();
        $deliveredCount = Bilty::where('status', 'Delivered')->count();
        $inTransitCount = Bilty::where('status', 'In-Transit')->count();
        $bookedCount = Bilty::where('status', 'Booked')->count();

        return view('admin.bilties.index', compact('bilties', 'totalCount', 'deliveredCount', 'inTransitCount', 'bookedCount'));
    }

    public function show($id)
    {
        $bilty = Bilty::findOrFail($id);
        return view('admin.bilties.show', compact('bilty'));
    }

    public function print($id)
    {
        $bilty = Bilty::findOrFail($id);
        return view('admin.bilties.print', compact('bilty'));
    }

    public function destroy($id)
    {
        $bilty = Bilty::findOrFail($id);
        $bilty->delete();

        return back()->with('success', 'Bilty record deleted successfully!');
    }
}
