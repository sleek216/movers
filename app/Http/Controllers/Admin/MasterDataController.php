<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MasterDataController extends Controller
{
    // ================= STATES =================
    public function states()
    {
        $states = DB::table('tbl_state')->orderBy('id', 'desc')->get();
        return view('admin.master_data.states', compact('states'));
    }

    public function storeState(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
        ]);

        $imgPath = '';
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/state'), $filename);
            $imgPath = 'images/state/' . $filename;
        }

        DB::table('tbl_state')->insert([
            'title' => $request->title,
            'img' => $imgPath,
            'status' => $request->status,
        ]);

        return back()->with('success', 'State added successfully!');
    }

    public function deleteState($id)
    {
        DB::table('tbl_state')->where('id', $id)->delete();
        return back()->with('success', 'State deleted successfully.');
    }

    public function toggleStateStatus($id)
    {
        $state = DB::table('tbl_state')->where('id', $id)->first();
        if ($state) {
            DB::table('tbl_state')->where('id', $id)->update(['status' => $state->status == 1 ? 0 : 1]);
        }
        return back()->with('success', 'State status updated.');
    }

    // ================= COUNTRY CODES =================
    public function countryCodes()
    {
        $codes = DB::table('tbl_code')->orderBy('id', 'desc')->get();
        return view('admin.master_data.country_codes', compact('codes'));
    }

    public function storeCountryCode(Request $request)
    {
        $request->validate([
            'ccode' => 'required|string|max:10',
            'status' => 'required|in:0,1',
        ]);

        DB::table('tbl_code')->insert([
            'ccode' => $request->ccode,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Country code added successfully!');
    }

    public function deleteCountryCode($id)
    {
        DB::table('tbl_code')->where('id', $id)->delete();
        return back()->with('success', 'Country code deleted successfully.');
    }

    // ================= FAQS =================
    public function faqs()
    {
        $faqs = DB::table('tbl_faq')->orderBy('id', 'desc')->get();
        return view('admin.master_data.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        DB::table('tbl_faq')->insert([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);

        return back()->with('success', 'FAQ added successfully!');
    }

    public function deleteFaq($id)
    {
        DB::table('tbl_faq')->where('id', $id)->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }

    // ================= PAGES =================
    public function pages()
    {
        $pages = DB::table('tbl_page')->orderBy('id', 'desc')->get();
        return view('admin.master_data.pages', compact('pages'));
    }

    public function storePage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        DB::table('tbl_page')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Page added successfully!');
    }

    public function updatePage(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        DB::table('tbl_page')->where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Page updated successfully!');
    }

    public function deletePage($id)
    {
        DB::table('tbl_page')->where('id', $id)->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
