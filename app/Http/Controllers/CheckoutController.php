<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Cart, Product, Voucher, ShippingMethod, Order};
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

        $selectedProducts = $request->query('selected_products'); // "1,2,3" misalnya

        if (!$selectedProducts) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih.');
        }

        // Ubah string menjadi array id produk
        $selectedIds = explode(',', $selectedProducts);

        // Ambil cart item yang user miliki dan masuk dalam selectedIds
        $cartItems = Cart::with('product')
                        ->where('user_id', $user->user_id)
                        ->whereIn('carts_id', $selectedIds)
                        ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Produk yang dipilih tidak ditemukan.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return optional($item->product)->price * $item->amount;
        });

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
            'voucher_id' => $voucher->id,
            'voucher_code' => $voucher->promotion_code
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,shipping_methods_id',
            'shipping_cost' => 'required|numeric|min:0',
        ]);
    
        $shippingMethod = ShippingMethod::where('shipping_methods_id', $request->shipping_method_id)->first(); // Updated query
    
    
        if (!$shippingMethod || $shippingMethod->cost != $request->shipping_cost) {
            return back()->with('error', 'Biaya pengiriman tidak valid.');
        }
    
        return DB::transaction(function () use ($request, $user, $shippingMethod) {
            $cartItems = Cart::with('product')->where('user_id', $user->user_id)->get();
    
            // ✅ Debug 3: Pastikan cart tidak kosong dan isi relasi product tersedia
            // dd($cartItems);
    
            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang belanja kosong.');
            }
    
            $subtotal = $cartItems->sum(fn ($item) => optional($item->product)->price * $item->amount);
            $shippingCost = $shippingMethod->cost;
            $discount = $request->voucher_discount ?? 0;
            $total = $subtotal + $shippingCost - $discount;
    
            // Generate unique order ID
            $orderId = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());
    
            // ✅ Debug 4: Tampilkan data order sebelum disimpan
            $orderData = [
                'order_id' => $orderId,
                'user_id' => $user->user_id,
                'order_status' => 'Belum Bayar',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_cost' => $shippingCost,
                'total_payment' => $total,
                'courier' => $shippingMethod->courier,
                'courier_service' => $shippingMethod->courier_service,
                'delivery_estimate' => $shippingMethod->delivery_estimate,
                'shipping_address' => json_encode([
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'city' => $user->city,
                    'province' => $user->province,
                    'postal_code' => $user->postal_code,
                ]),
                'expires_at' => now()->addHours(24), // ✅ tambahan ini
            ];
    
            // dd($orderData); // Ini yang benar, bukan dd($order) sebelum didefinisikan
    
            $order = Order::create($orderData);
    
            // ✅ Debug 5: Cek hasil create order
            // dd($order);
    
            foreach ($cartItems as $item) {
                if (!$item->product) {
                    \Log::warning('Produk tidak ditemukan untuk cart item ID: ' . $item->id);
                    continue;
                }
            
                $product = $item->product;
            
                // Cek apakah stok cukup
                if ($product->stock < $item->amount) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $product->products_name);
                }
            
                // Kurangi stok produk
                $product->stock -= $item->amount;
                $product->save();
            
                $itemData = [
                    'products_id' => $product->products_id,
                    'products_name' => $product->products_name,
                    'amount' => $item->amount,
                    'price' => $product->price,
                    'subtotal' => $product->price * $item->amount,
                    'discount' => 0,
                    'total' => $product->price * $item->amount,
                ];
                        
    
                // dd($itemData); // ✅ Debug 6: Cek data item sebelum disimpan ke order_items
    
                $order->items()->create($itemData);
            }
    
            Cart::where('user_id', $user->user_id)->delete();
    
            return redirect()->route('orders.index', ['id' => $order->order_id])
                ->with('success', 'Order berhasil dibuat.');
        });
    }
    
}
