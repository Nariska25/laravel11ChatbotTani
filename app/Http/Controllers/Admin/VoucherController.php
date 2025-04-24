<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotion_code' => 'required|string|unique:vouchers',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'quantity' => 'required|integer',
            'promotion_type' => 'required|in:percentage,fixed_amount',
            'promotion_item' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'required|numeric',
        ]);

        $imagePath = null;
        if ($request->hasFile('promotion_item')) {
            $imagePath = $request->file('promotion_item')->store('promotion_items', 'public');
        }

        Voucher::create([
            'promotion_code' => $request->promotion_code,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'quantity' => $request->quantity,
            'promotion_type' => $request->promotion_type,
            'promotion_item' => $imagePath,
            'discount' => $request->discount,
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully.');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'promotion_item' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $voucher->promotion_code = $request->promotion_code;

        if ($request->hasFile('promotion_item')) {
            $path = $request->file('promotion_item')->store('promotion_items', 'public');
            $voucher->promotion_item = $path;
        }

        $voucher->save();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher updated successfully!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher deleted successfully.');
    }
}
