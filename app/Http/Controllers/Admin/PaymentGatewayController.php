<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = DB::table('tbl_payment_list')->get();
        return view('admin.payments.index', compact('gateways'));
    }

    public function edit($id)
    {
        $gateway = DB::table('tbl_payment_list')->where('id', $id)->first();
        if (!$gateway) {
            return redirect()->route('admin.payments.index')->with('error', 'Payment gateway not found.');
        }
        return view('admin.payments.edit', compact('gateway'));
    }

    public function update(Request $request, $id)
    {
        $gateway = DB::table('tbl_payment_list')->where('id', $id)->first();
        if (!$gateway) {
            return redirect()->route('admin.payments.index')->with('error', 'Payment gateway not found.');
        }

        $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'status' => 'required|in:0,1',
            'attributes' => 'nullable|string',
            'p_show' => 'nullable|string',
        ]);

        $imgPath = $gateway->img;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/payment'), $filename);
            $imgPath = 'images/payment/' . $filename;
        }

        DB::table('tbl_payment_list')->where('id', $id)->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle ?? '',
            'status' => $request->status,
            'attributes' => $request->attributes ?? '',
            'p_show' => $request->p_show ?? '1',
            'img' => $imgPath,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment gateway configuration updated successfully!');
    }
}
