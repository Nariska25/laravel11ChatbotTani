<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori
        $categories = Categories::all();

        // Filter produk berdasarkan kategori yang dipilih
        if ($request->has('kategori') && $request->kategori != 'all') {
            $products = Products::where('kategori_id', $request->kategori)->get();  // Menyaring berdasarkan kategori_id
        } else {
            $products = Products::all();  // Menampilkan semua produk jika kategori 'All' dipilih
        }

        // Kirim data kategori dan produk ke view
        return view('shop', compact('categories', 'products'));
    }
}
