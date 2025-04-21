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
use Illuminate\Support\Facades\Log;

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
        Log::info("Masuk ke method pay() untuk order ID: $id");
    
        $order = Order::where('user_id', Auth::id())
            ->where('order_id', $id)
            ->firstOrFail();
    
        Log::info("Order ditemukan: " . json_encode($order));
    
        if ($order->order_status !== 'Belum Bayar') {
            Log::warning("Order status bukan 'Belum Bayar'. Status saat ini: " . $order->order_status);
            return redirect()->back()->with('error', 'Order sudah diproses atau dibatalkan.');
        }
    
        try {
            // Ambil API key dari config
            $xenditKey = config('services.xendit.secret_key');
            Log::info("Xendit API Key: " . ($xenditKey ? '[TERSEDIA]' : '[TIDAK ADA]'));

            if (empty($xenditKey)) {
                Log::error("API Key Xendit kosong. Cek .env dan jalankan config:clear");
                return redirect()->back()->with('error', 'API Key Xendit belum diatur.');
            }

    
            // Setup konfigurasi Xendit
            $config = Configuration::getDefaultConfiguration()->setApiKey($xenditKey);
            Log::info("Konfigurasi Xendit berhasil di-setup.");
    
            $apiInstance = new InvoiceApi(new Client(), $config);
    
            if (empty($order->xendit_payment_url)) {
                $createInvoiceRequest = new CreateInvoiceRequest([
                    'external_id' => 'order-' . $order->id,
                    'payer_email' => $order->user->email,
                    'description' => 'Payment for Order #' . $order->id,
                    'amount' => (int) $order->total_payment,
                    'success_redirect_url' => route('orders.show', $order->order_id),
                    'callback_url' => 'https://bb46-110-139-192-224.ngrok-free.app/xendit/webhook',
                ]);
    
                // Debug isi request
                Log::info("Request invoice (CreateInvoiceRequest):", [
                    'external_id' => 'order-' . $order->id,
                    'payer_email' => $order->user->email,
                    'description' => 'Payment for Order #' . $order->id,
                    'amount' => $order->total_payment,
                    'success_redirect_url' => route('orders.show', $order->order_id),
                    'callback_url' => 'https://bb46-110-139-192-224.ngrok-free.app/xendit/webhook',
                ]);
    
                $result = $apiInstance->createInvoice($createInvoiceRequest);
    
                Log::info("Invoice berhasil dibuat: " . json_encode($result));
    
                $order->xendit_invoice_id = $result['id'];
                $order->xendit_payment_url = $result['invoice_url'];
                $order->save();
            } else {
                Log::info("Invoice sudah ada, langsung redirect.");
            }
    
            return redirect($order->xendit_payment_url);
    
        } catch (\Exception $e) {
            Log::error("Gagal membuat invoice: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }
}    
