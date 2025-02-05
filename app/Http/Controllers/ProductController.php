<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  // Tambahkan untuk penggunaan Storage

class ProductController extends Controller
{
    // Method untuk menampilkan daftar produk
    public function index()
{
    $products = Products::with('kategori')->get(); // Mengambil data dengan kategori
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
            'nama_produk' => 'required|string|max:255',
            'gambar_produk' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'deskripsi_produk' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:categories,kategori_id', // Validasi kategori
        ]);

        // Proses gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar_produk')) {
            $gambarPath = $request->file('gambar_produk')->store('produk_images', 'public');
        }

        // Simpan data produk baru
        $product = new Products([
            'nama_produk' => $validated['nama_produk'],
            'gambar_produk' => $gambarPath, // Simpan path gambar di sini
            'deskripsi_produk' => $validated['deskripsi_produk'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'kategori_id' => $validated['kategori_id'],
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
    
    // Validasi input
    $validated = $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'stok' => 'nullable|integer|min:0',
        'deskripsi_produk' => 'nullable|string',
        'kategori_id' => 'nullable|exists:categories,kategori_id',
    ]);
    
    // Cek gambar baru dan hapus gambar lama jika perlu
    if ($request->hasFile('gambar_produk')) {
        // Hapus gambar lama jika ada
        if ($product->gambar_produk) {
            Storage::delete('public/' . $product->gambar_produk);
        }

        // Simpan gambar baru
        $gambarPath = $request->file('gambar_produk')->store('produk_images', 'public');
    } else {
        // Jika gambar tidak diubah, tetap gunakan gambar lama
        $gambarPath = $product->gambar_produk;
    }
    
    // Update produk hanya dengan data yang ada di request
    $product->update([
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,  // Pastikan harga diperbarui jika ada perubahan
        'gambar_produk' => $gambarPath, // Hanya update gambar jika ada perubahan
        'stok' => $request->stok,
        'deskripsi_produk' => $request->deskripsi_produk,
        'kategori_id' => $request->kategori_id, 
    ]);
    
    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui');
}

    

    // Method untuk menghapus produk
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        // Hapus gambar sebelum menghapus produk jika ada
        if ($product->gambar_produk) {
            Storage::delete('public/' . $product->gambar_produk);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
    

    public function show($produk_id)
    {
        // Ambil data produk berdasarkan produk_id
        $product = Products::findOrFail($produk_id);
        
        // Kirim data ke view dengan nama variabel yang konsisten
        return view('detail', compact('product'));
  // Pastikan variabel 'produk' konsisten
    }
    
    
    
}


