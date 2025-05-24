<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Cart, CartDetail, Product, Voucher, ShippingMethod, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $selectedProducts = $request->query('selected_products');

        if (!$selectedProducts) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        // Ubah string menjadi array id cart_detail
        $selectedIds = explode(',', $selectedProducts);

        // Ambil cart user
        $cart = Cart::with(['cartDetails' => function($query) use ($selectedIds) {
            $query->whereIn('carts_detail_id', $selectedIds)->with('product');
        }])->where('user_id', $user->user_id)->first();

        if (!$cart || $cart->cartDetails->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        $cartItems = $cart->cartDetails;
        $subtotal = $cartItems->sum('subtotal');

        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        return view('checkout', compact(
            'user',
            'cartItems',
            'subtotal',
            'shippingMethods'
        ));
    }

    public function applyVoucher(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $voucher = Voucher::where('promotion_code', $request->code)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('quantity', '>', 0)
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'error' => 'Voucher tidak valid atau sudah kedaluwarsa.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan.',
            'discount' => $voucher->discount,
            'voucher_id' => $voucher->vouchers_id,
            'voucher_code' => $voucher->promotion_code
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,shipping_methods_id',
            'shipping_cost' => 'required|numeric|min:0',
            'selected_items' => 'required|string' // ID cart details yang dipilih
        ]);
    
        $selectedIds = explode(',', $request->selected_items);
        $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
    
        if ($shippingMethod->cost != $request->shipping_cost) {
            return back()->with('error', 'Biaya pengiriman tidak valid.');
        }
    
        return DB::transaction(function () use ($request, $user, $shippingMethod, $selectedIds) {
            // Ambil cart user
            $cart = Cart::with(['cartDetails' => function($query) use ($selectedIds) {
                $query->whereIn('carts_detail_id', $selectedIds)->with('product');
            }])->where('user_id', $user->user_id)->first();
    
            if (!$cart || $cart->cartDetails->isEmpty()) {
                return back()->with('error', 'Keranjang belanja kosong.');
            }
    
            $cartItems = $cart->cartDetails;
            $subtotal = $cartItems->sum('subtotal');
            $shippingCost = $shippingMethod->cost;
            $discount = $request->voucher_discount ?? 0;
            $total = $subtotal + $shippingCost - $discount;
    
            // Generate unique order ID
            $orderId = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    
            $order = Order::create([
                'order_id' => $orderId,
                'user_id' => $user->user_id,
                'vouchers_id' => $request->voucher_id ?? null,
                'shipping_methods_id' => $shippingMethod->shipping_methods_id,
                'order_status' => 'Belum Bayar',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_cost' => $shippingCost,
                'total_payment' => $total,
                'expires_at' => now()->addHours(24),
            ]);
    
            foreach ($cartItems as $item) {
                $product = $item->product;
            
                if (!$product) {
                    \Log::warning('Produk tidak ditemukan untuk cart detail ID: ' . $item->carts_detail_id);
                    continue;
                }
            
                if ($product->stock < $item->amount) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $product->products_name);
                }
            
                // Kurangi stok produk
                $product->stock -= $item->amount;
                $product->save();
            
                $order->items()->create([
                    'products_id' => $product->products_id,
                    'products_name' => $product->products_name,
                    'amount' => $item->amount,
                    'subtotal' => $item->subtotal,
                ]);
            }
    
            // Hapus hanya item yang dipilih dari cart
            CartDetail::whereIn('carts_detail_id', $selectedIds)->delete();
    
            // Update total cart
            $cart->total = $cart->cartDetails()->sum('subtotal');
            $cart->save();
    
            return redirect()->route('orders.index', ['id' => $order->order_id])
                ->with('success', 'Order berhasil dibuat.');
        });
    }
}