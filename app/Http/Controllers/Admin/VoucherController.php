<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::paginate(6);

        foreach ($vouchers as $voucher) {
            // Pastikan end_date diperiksa hingga akhir hari
            $voucher->status = now()->gt(Carbon::parse($voucher->end_date)) ? 0 : 1;
            $voucher->save();
        }

        return view('admin.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotion_code'   => 'required|string|unique:vouchers',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after:start_date',
            'quantity'         => 'required|integer',
            'promotion_item'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount'         => 'required|numeric',
        ]);

        $imagePath = null;
        if ($request->hasFile('promotion_item')) {
            $imagePath = $request->file('promotion_item')->store('promotion_items', 'public');
        }

        // Simpan tanggal dan waktu persis dari input form
        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);

        $voucher = Voucher::create([
            'promotion_code'   => $request->promotion_code,
            'start_date'       => $startDate,
            'end_date'         => $endDate,
            'quantity'         => $request->quantity,
            'promotion_item'   => $imagePath,
            'discount'         => $request->discount,
            'status'           => now()->gt($endDate) ? 0 : 1,
        ]);

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher created successfully.');
    }


    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin.voucher.index')->with('success', 'Voucher deleted successfully.');
    }
}
