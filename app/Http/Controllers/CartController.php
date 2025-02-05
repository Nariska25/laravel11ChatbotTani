<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tampilkan halaman keranjang
    public function index()
    {
        // Ambil semua data dari tabel keranjang beserta data produk terkait
        $cartItems = Cart::with('produk')->get(); // Pastikan relasi 'produk' sudah benar di model Cart
    
        // Kirim data ke view 'cart.blade.php'
        return view('cart', ['carts' => $cartItems]);
    }
    

    // Tambah produk ke keranjang
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:products,produk_id',
            'jumlah' => 'required|integer|min:1',
        ]);
    
        $produk_id = $request->input('produk_id');
        $jumlah = $request->input('jumlah');
    
        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('produk_id', $produk_id)->first();
    
        if ($cartItem) {
            $cartItem->jumlah += $jumlah;
            $cartItem->save();
        } else {
            Cart::create([
                'produk_id' => $produk_id,
                'jumlah' => $jumlah,
            ]);
        }
    
        // Redirect ke halaman keranjang setelah menyimpan
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    

    // Hapus produk dari keranjang
    public function delete($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang');
    }
}
