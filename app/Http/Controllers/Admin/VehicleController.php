<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = DB::table('tbl_vehicle')->orderBy('id', 'desc')->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'min_weight' => 'required|numeric',
            'max_weight' => 'required|numeric',
            'status' => 'required|in:0,1',
            'img' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $imgPath = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/vehicle'), $filename);
            $imgPath = 'images/vehicle/' . $filename;
        }

        DB::table('tbl_vehicle')->insert([
            'title' => $request->title,
            'img' => $imgPath,
            'min_weight' => $request->min_weight,
            'max_weight' => $request->max_weight,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle category added successfully!');
    }

    public function edit($id)
    {
        $vehicle = DB::table('tbl_vehicle')->where('id', $id)->first();
        if (!$vehicle) {
            return redirect()->route('admin.vehicles.index')->with('error', 'Vehicle not found.');
        }
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = DB::table('tbl_vehicle')->where('id', $id)->first();
        if (!$vehicle) {
            return redirect()->route('admin.vehicles.index')->with('error', 'Vehicle not found.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'min_weight' => 'required|numeric',
            'max_weight' => 'required|numeric',
            'status' => 'required|in:0,1',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $imgPath = $vehicle->img;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/vehicle'), $filename);
            $imgPath = 'images/vehicle/' . $filename;
        }

        DB::table('tbl_vehicle')->where('id', $id)->update([
            'title' => $request->title,
            'img' => $imgPath,
            'min_weight' => $request->min_weight,
            'max_weight' => $request->max_weight,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle category updated successfully!');
    }

    public function destroy($id)
    {
        $vehicle = DB::table('tbl_vehicle')->where('id', $id)->first();
        if ($vehicle) {
            if ($vehicle->img && File::exists(public_path($vehicle->img))) {
                File::delete(public_path($vehicle->img));
            }
            DB::table('tbl_vehicle')->where('id', $id)->delete();
        }
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $vehicle = DB::table('tbl_vehicle')->where('id', $id)->first();
        if (!$vehicle) {
            return back()->with('error', 'Vehicle not found.');
        }

        $newStatus = $vehicle->status == 1 ? 0 : 1;
        DB::table('tbl_vehicle')->where('id', $id)->update(['status' => $newStatus]);

        return back()->with('success', 'Vehicle status updated successfully.');
    }
}
