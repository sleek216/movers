<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = DB::table('banner')->orderBy('id', 'desc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'b_type' => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
            'img' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $imgPath = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/banner'), $filename);
            $imgPath = 'images/banner/' . $filename;
        }

        DB::table('banner')->insert([
            'img' => $imgPath,
            'status' => $request->status,
            'b_type' => $request->b_type ?? 'User',
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner added successfully!');
    }

    public function destroy($id)
    {
        $banner = DB::table('banner')->where('id', $id)->first();
        if ($banner) {
            if ($banner->img && File::exists(public_path($banner->img))) {
                File::delete(public_path($banner->img));
            }
            DB::table('banner')->where('id', $id)->delete();
        }
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $banner = DB::table('banner')->where('id', $id)->first();
        if (!$banner) {
            return back()->with('error', 'Banner not found.');
        }

        $newStatus = $banner->status == 1 ? 0 : 1;
        DB::table('banner')->where('id', $id)->update(['status' => $newStatus]);

        return back()->with('success', 'Banner status updated successfully.');
    }
}
