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
        $totalPrice = $subtotal;

        return view('cart', compact('cart', 'cartItems', 'subtotal', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,products_id',
            'amount' => 'required|integer|min:1',
        ]);

        $product = Products::with('activeSale')->findOrFail($request->products_id);

        if ($request->amount > $product->stock) {
            return back()->with('error', 'Jumlah produk melebihi stok yang tersedia.');
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['total' => 0]
        );

        $cartDetail = $cart->cartDetails()->where('products_id', $product->products_id)->first();

        $discount = $product->activeSale->discount_value ?? 0;
        $unitPrice = $product->discounted_price;
        
        if ($cartDetail) {
            $totalAmount = $cartDetail->amount + $request->amount;

            if ($totalAmount > $product->stock) {
                return back()->with('error', 'Jumlah total melebihi stok yang tersedia.');
            }

            $cartDetail->amount = $totalAmount;
            $cartDetail->discount = $discount;
            $cartDetail->subtotal = $unitPrice * $totalAmount;
        } else {
            $cartDetail = new CartDetail([
                'products_id' => $product->products_id,
                'amount' => $request->amount,
                'discount' => $discount,
                'subtotal' => $unitPrice * $request->amount,
            ]);
            $cart->cartDetails()->save($cartDetail);
        }

        $this->updateCartTotal($cart);
        $this->updateCartCount();

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

public function update(Request $request, $id)
{
    $cartDetail = CartDetail::find($id);

    if (!$cartDetail) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    $amount = intval($request->amount);

    if ($amount < 1) {
        return response()->json(['message' => 'Jumlah harus minimal 1'], 400);
    }

    if ($amount > $cartDetail->product->stock) {
        return response()->json([
            'message' => 'Stok tidak mencukupi',
            'max_stock' => $cartDetail->product->stock
        ], 400);
    }

    $cartDetail->amount = $amount;
    $cartDetail->subtotal = $amount * $cartDetail->product->discounted_price;
    $cartDetail->save();

    $cart = $cartDetail->cart;
    $this->updateCartTotal($cart); // update total harga di carts
    $this->updateCartCount();      // update session cart count

    return response()->json([
        'message' => 'Jumlah berhasil diupdate',
        'subtotal' => $cartDetail->subtotal,
        'cart_count' => $this->getCartCount()
    ]);
}



    public function remove($cartDetailId)
    {
        $cartDetail = CartDetail::where('carts_detail_id', $cartDetailId)
            ->whereHas('cart', function ($query) {
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
        $total = $cart->cartDetails->sum('subtotal'); // Sudah pakai eager loaded
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
