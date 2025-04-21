<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(5); 

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('orders.show', compact('order'));
    }

    public function cancel($id): RedirectResponse
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_id', $id)
            ->firstOrFail();

        if ($order->order_status !== 'Belum Bayar') {
            return redirect()->back()
                ->with('error', 'Order tidak dapat dibatalkan.');
        }

        $order->order_status = 'Dibatalkan';
        $order->save();

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function pay($id): RedirectResponse
    {
        // Ambil order
        $order = Order::where('user_id', Auth::id())
            ->where('order_id', $id)
            ->firstOrFail();
    
        if ($order->order_status !== 'Belum Bayar') {
            return redirect()->back()->with('error', 'Order sudah diproses atau dibatalkan.');
        }
    
        // Setup konfigurasi
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey(config('services.xendit.secret_key'));
    
        // Buat InvoiceApi instance
        $apiInstance = new InvoiceApi(new Client(), $config);
    
        if (empty($order->xendit_payment_url)) {
            try {
                $createInvoiceRequest = new CreateInvoiceRequest([
                    'external_id' => 'invoice_' . $order->id,  // Pastikan formatnya konsisten
                    'payer_email' => $order->user->email,
                    'description' => 'Payment for Order #' . $order->id,
                    'amount' => $order->total_payment,
                    'success_redirect_url' => route('orders.show', $order->order_id),
                    'callback_url' => 'https://a19f-103-153-149-59.ngrok-free.app/xendit/webhook', // <== ini penting!
                ]);
                
    
                $result = $apiInstance->createInvoice($createInvoiceRequest);
    
                $order->xendit_invoice_id = $result['id'];
                $order->xendit_payment_url = $result['invoice_url'];
                $order->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
            }
        }
    
        return redirect($order->xendit_payment_url);
    }
}