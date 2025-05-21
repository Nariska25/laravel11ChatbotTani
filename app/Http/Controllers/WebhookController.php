<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; 
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleXenditWebhook(Request $request)
    {
        $token = $request->header('X-CALLBACK-TOKEN');
        $expectedToken = config('services.xendit.callback_token');
    
        Log::info('Token yang diterima dari header: ' . $token);
        Log::info('Token yang diharapkan: ' . $expectedToken);
    
        if ($token !== $expectedToken) {
            Log::warning('Token tidak valid');
            return response()->json(['message' => 'Invalid token'], 403);
        }
    
        Log::info('Xendit Webhook diterima:', $request->all());
    
        $invoiceId = $request->input('id');
        $status = $request->input('status');
    
        $order = Order::with('items.product')->where('xendit_invoice_id', $invoiceId)->first();
    
        if ($order) {
            if ($status === 'PAID') {
                $order->order_status = 'Telah Dibayar';
                $order->save();
    
                // Kurangi stok untuk setiap item dalam pesanan
                foreach ($order->items as $item) {
                    if ($item->product) {
                        if ($item->product->stock >= $item->amount) {
                            $item->product->stock -= $item->amount;
                        } else {
                            $item->product->stock = 0;
                        }
                        $item->product->save();
                    }
                }
    
            } elseif ($status === 'EXPIRED') {
                $order->order_status = 'Kadaluarsa';
                $order->save();
            } elseif ($status === 'FAILED') {
                $order->order_status = 'Dibatalkan';
                $order->save();
            }
    
            Log::info("Order {$order->order_id} diupdate menjadi: {$order->order_status}");
        } else {
            Log::warning("Order tidak ditemukan untuk invoice_id: $invoiceId");
        }
    
        return response()->json(['status' => 'ok']);
    }
}    