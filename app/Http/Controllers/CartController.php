<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getUserCart();
        $cartItems = $cart ? $cart->cartDetails()->with('product')->get() : collect();
        $cartCount = $cartItems->sum('amount');
        session()->put('cart_count', $cartCount);

        $subtotal = $this->calculateSubtotal($cartItems);
        $totalPrice = $subtotal - ($cart->discount ?? 0);

        return view('cart', compact('cart', 'cartItems', 'subtotal', 'totalPrice'));
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

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['discount' => 0, 'total' => 0]
        );

        $cartDetail = $cart->cartDetails()->where('products_id', $request->products_id)->first();

        if ($cartDetail) {
            $cartDetail->amount += $request->amount;
        } else {
            $cartDetail = new CartDetail([
                'products_id' => $request->products_id,
                'amount' => $request->amount,
            ]);
        }

        $cartDetail->subtotal = $product->price * $cartDetail->amount;
        $cart->cartDetails()->save($cartDetail);

        $this->updateCartTotal($cart);
        $this->updateCartCount();

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $cartDetail = CartDetail::where('carts_detail_id', $id)
                      ->whereHas('cart', function($query) {
                          $query->where('user_id', Auth::id());
                      })->firstOrFail();

        $product = $cartDetail->product;

        if ($request->amount > $product->stock) {
            return response()->json([
                'success' => false, 
                'message' => 'Jumlah melebihi stok yang tersedia',
                'max_stock' => $product->stock
            ], 400);
        }

        $cartDetail->amount = $request->amount;
        $cartDetail->subtotal = $product->price * $cartDetail->amount;
        $cartDetail->save();

        $cart = $cartDetail->cart;
        $this->updateCartTotal($cart);
        $this->updateCartCount();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui',
            'subtotal' => number_format($cartDetail->subtotal, 0, ',', '.'),
            'total' => number_format($cart->total, 0, ',', '.'),
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function remove($cartDetailId)
    {
        $cartDetail = CartDetail::where('carts_detail_id', $cartDetailId)
                      ->whereHas('cart', function($query) {
                          $query->where('user_id', Auth::id());
                      })->firstOrFail();

        $cart = $cartDetail->cart;
        $cartDetail->delete();

        if ($cart) {
            $this->updateCartTotal($cart);
        }

        $this->updateCartCount();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $cart = $this->getUserCart();
        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Validasi stok produk
        foreach ($cart->cartDetails as $item) {
            if (!$item->product) {
                return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan.');
            }

            if ($item->amount > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', 
                    'Stok produk ' . $item->product->products_name . ' tidak mencukupi. Stok tersedia: ' . $item->product->stock);
            }
        }

        return redirect()->route('checkout.index');
    }

    // ============ HELPER METHODS ============
    private function getUserCart()
    {
        return Cart::with('cartDetails.product')->where('user_id', Auth::id())->first();
    }

    private function calculateSubtotal($cartItems)
    {
        return $cartItems->sum('subtotal');
    }

    private function updateCartTotal(Cart $cart)
    {
        $total = $cart->cartDetails()->sum('subtotal');
        $cart->update(['total' => $total]);
    }

    private function updateCartCount()
    {
        session()->put('cart_count', $this->getCartCount());
    }

    private function getCartCount()
    {
        $cart = $this->getUserCart();
        return $cart ? $cart->cartDetails->sum('amount') : 0;
    }
}