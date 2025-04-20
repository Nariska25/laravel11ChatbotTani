<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Sale;
use App\Models\Products; 
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Tampilkan semua data sales
    public function index()
    {
        $sales = Sale::with('products')->latest()->get();
        return view('admin.sales.index', compact('sales'));
    }

    // Form tambah sale baru
    public function create()
    {
        $products = Products::all();
        return view('admin.sales.create', compact('products'));
    }

    // Simpan data sales baru
    public function store(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,products_id',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        Sale::create($request->all());
        return redirect()->route('admin.sales.index')->with('success', 'Sale berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('admin.sales.edit', compact('sale'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
    
        $sale = Sale::findOrFail($id);
        $sale->update([
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
    
        return redirect()->route('admin.sales.index')->with('success', 'Sale berhasil diperbarui!');
    }
    
    // Hapus data sales
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('admin.sales.index')->with('success', 'Sale berhasil dihapus!');
    }
}
