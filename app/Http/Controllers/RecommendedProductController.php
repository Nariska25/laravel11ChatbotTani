<?php

namespace App\Http\Controllers;
use App\Models\RecommendedProduct;
use Illuminate\Http\Request;


class RecommendedProductController extends Controller
{

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        'category' => 'required|string',
    ]);

    $imagePath = $request->file('image')->store('products', 'public');

    RecommendedProduct::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $imagePath,
        'category' => $request->category,
    ]);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
}

}

