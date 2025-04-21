<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getUserCartItems();
        $cartCount = $cartItems->sum('amount');
        session()->put('cart_count', $cartCount);

        $subtotal = $this->calculateSubtotal($cartItems);
        $totalPrice = $subtotal; // tanpa diskon

        return view('cart', compact('cartItems', 'subtotal', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,products_id',
            'amount' => 'required|integer|min:1',
        ]);

        $product = Products::findOrFail($request->products_id);

        if ($request->amount > $product->stock) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }

        $cartItem = Cart::where('products_id', $request->products_id)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($cartItem) {
            $cartItem->amount += $request->amount;
        } else {
            $cartItem = new Cart([
                'products_id' => $request->products_id,
                'amount' => $request->amount,
                'user_id' => Auth::id(),
            ]);
        }

        $cartItem->subtotal = $product->price * $cartItem->amount;
        $cartItem->total = $cartItem->subtotal; // total sama dengan subtotal
        $cartItem->save();

        $this->updateCartCount();
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);
        $product = $cart->product;

        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => 'Jumlah melebihi stok yang tersedia',
                'max_stock' => $product->stock
            ], 400);
        }

        $cart->amount = $request->quantity;
        $cart->subtotal = $product->price * $cart->amount;
        $cart->total = $cart->subtotal; // tanpa diskon
        $cart->save();

        $this->updateCartCount();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui',
            'subtotal' => number_format($cart->subtotal, 0, '.', '.'),
            'total' => number_format($cart->total, 0, '.', '.'),
            'cart_count' => Cart::where('user_id', Auth::id())->sum('amount')
        ]);
    }

    public function remove($cartId)
    {
        $cartItem = Cart::where('carts_id', $cartId)
                       ->where('user_id', Auth::id())
                       ->firstOrFail();

        $cartItem->delete();
        $this->updateCartCount();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            dd("User tidak terautentikasi!");
        }

        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            dd("Cart kosong! Tidak bisa checkout.");
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        foreach ($cartItems as $item) {
            if (!$item->product) {
                dd("Produk dengan ID " . $item->products_id . " tidak ditemukan!");
            }

            if ($item->amount > $item->product->stock) {
                dd("Stok produk " . $item->product->products_name . " kurang! Stok tersedia: " . $item->product->stock);
                return redirect()->route('cart.index')->with('error', 
                    'Stok produk ' . $item->product->products_name . ' tidak mencukupi.');
            }
        }

        dd("Semua cek lolos! Redirect ke checkout."); 
        return redirect()->route('checkout.index');
    }

    // Private helper methods
    private function getUserCartItems()
    {
        return Cart::with('product')->where('user_id', Auth::id())->get();
    }

    private function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(fn($cartItem) => optional($cartItem->product)->price * $cartItem->amount ?? 0);
    }

    private function updateCartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->sum('amount');
        session()->put('cart_count', $cartCount);
    }
}
