<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;   // Tambahkan untuk penggunaan Storage

class ProductController extends Controller
{
    // Method untuk menampilkan daftar produk
    public function index()
{
    $products = Products::with('category')->orderBy('recommendation', 'desc')->get();
    return view('admin.products.index', compact('products'));
}


    // Method untuk menampilkan form tambah produk
    public function create()
    {
        $categories = Categories::all(); // Ambil semua kategori untuk dropdown
        return view('admin.products.create', compact('categories'));
    }

    // Method untuk menyimpan produk baru
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'products_name' => 'required|string|max:255',
        'products_image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        'products_description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,category_id', // Validasi kategori
        'recommendation' => 'sometimes|boolean',
    ]);

    // Proses gambar jika ada
    $gambarPath = null;
    if ($request->hasFile('products_image')) {
        $gambarPath = $request->file('products_image')->store('products_image', 'public');
    }

    // Simpan data produk baru
    $product = new Products([
        'products_name' => $validated['products_name'],
        'products_image' => $gambarPath, // Simpan path gambar di sini
        'products_description' => $validated['products_description'],
        'price' => $validated['price'],
        'stock' => $validated['stock'],
        'category_id' => $validated['category_id'],
        'recommendation' => $request->has('recommendation') ? 1 : 0, // Pastikan nilai recommendation yang dikirimkan
    ]);
    $product->save(); // Simpan ke database

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
}


    // Method untuk mengedit produk
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Method untuk mengupdate produk
    public function update(Request $request, $id)
{
    $product = Products::findOrFail($id);
    
    $validated = $request->validate([
        'products_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'products_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'stock' => 'nullable|integer|min:0',
        'products_description' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,category_id',
        'recommendation' => 'sometimes|boolean', // ✅
    ]);
    
    if ($request->hasFile('products_image')) {
        if ($product->products_image) {
            Storage::delete('public/' . $product->products_image);
        }
        $gambarPath = $request->file('products_image')->store('products_images', 'public');
    } else {
        $gambarPath = $product->products_image;
    }

    $product->update([
        'products_name' => $validated['products_name'],
        'price' => $validated['price'],
        'products_image' => $gambarPath,
        'stock' => $validated['stock'] ?? $product->stock,
        'products_description' => $validated['products_description'] ?? $product->products_description,
        'category_id' => $validated['category_id'] ?? $product->category_id,
        'recommendation' => $request->has('recommendation') ? 1 : 0, // ✅ Fix checkbox
    ]);

    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
}
    


public function updateRekomendasi(Request $request, $id)
{
    $product = Products::findOrFail($id);
    $product->recommendation = $request->rekomendasi; // Pastikan nilai rekomendasi (0 atau 1)
    $product->save();

    return response()->json(['message' => 'Status rekomendasi berhasil diperbarui.']);
}


    // Method untuk menghapus produk
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        // Hapus gambar sebelum menghapus produk jika ada
        if ($product->products_image) {
            Storage::delete('public/' . $product->products_image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
    

    public function show($products_id)
    {
        // Ambil data produk berdasarkan produk_id
        $product = Products::findOrFail($products_id);
        
        // Kirim data ke view dengan nama variabel yang konsisten
        return view('detail', compact('product'));
  // Pastikan variabel 'produk' konsisten
    }
    
    
    
}


