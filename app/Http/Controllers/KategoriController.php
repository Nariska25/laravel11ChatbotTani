<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Products;
class KategoriController extends Controller
{
    public function index()
    {
        $categories = Categories::all(); // Ambil semua kategori
        return view('admin.categories.index', compact('categories'));
    }

        public function create()
    {
        $categories = Categories::all(); // Ambil semua kategori
        return view('admin.products.create', compact('categories'));
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all(); // Ambil semua kategori
        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi_kategori' => 'nullable|string|max:500',
        ]);

        Categories::create($request->all());  // Menyimpan kategori baru
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index');
    }
}
