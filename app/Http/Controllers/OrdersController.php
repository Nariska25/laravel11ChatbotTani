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
    Log::info("Mulai proses bayar untuk order ID: {$id}");
    
    $order = Order::where('user_id', Auth::id())
        ->where('order_id', $id)
        ->firstOrFail();
    
    Log::info("Order ditemukan: " . json_encode($order));
    
    if ($order->order_status !== 'Belum Bayar') {
        Log::warning("Order status bukan 'Belum Bayar'. Status saat ini: " . $order->order_status);
        return redirect()->back()->with('error', 'Order sudah diproses atau dibatalkan.');
    }
    
    try {
        $xenditKey = config('services.xendit.secret_key');
        Log::info("Xendit API Key: " . ($xenditKey ? '[TERSEDIA]' : '[TIDAK ADA]'));
    
        if (empty($xenditKey)) {
            Log::error("API Key Xendit kosong.");
            return redirect()->back()->with('error', 'API Key Xendit belum diatur.');
        }
    
        $config = Configuration::getDefaultConfiguration()->setApiKey($xenditKey);
        Log::info("Konfigurasi Xendit berhasil di-setup.");
    
        $apiInstance = new InvoiceApi(new Client(), $config);
    
        if (empty($order->xendit_payment_url)) {
            $externalId = 'order-' . $order->order_id;
            $payerEmail = $order->user->email ?? 'dummy@email.com';
            $description = 'Payment for Order #' . $order->order_id;
            $amount = (int) $order->total_payment;
            $successUrl = route('orders.show', $order->order_id);
            $callbackUrl = 'https://d5b5-36-75-132-143.ngrok-free.app/xendit/webhook';  // pastikan route webhook sudah terdaftar
            
            Log::info("Membuat invoice Xendit dengan data:", [
                'external_id' => $externalId,
                'payer_email' => $payerEmail,
                'description' => $description,
                'amount' => $amount,
                'success_redirect_url' => $successUrl,
                'callback_url' => $callbackUrl,
            ]);
    
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => $externalId,
                'payer_email' => $payerEmail,
                'description' => $description,
                'amount' => $amount,
                'success_redirect_url' => $successUrl,
                'callback_url' => $callbackUrl,
            ]);
    
            $result = $apiInstance->createInvoice($createInvoiceRequest);
    
            Log::info("Invoice berhasil dibuat: " . json_encode($result));
    
            // Simpan hasil invoice ke database
            $order->xendit_invoice_id = $result['id'];
            $order->external_id = $result['external_id'];
            $order->xendit_payment_url = $result['invoice_url'];
            $order->save();
        } else {
            Log::info("Invoice sudah ada, langsung redirect.");
        }
    
        Log::info("Redirect ke URL pembayaran Xendit: " . $order->xendit_payment_url);
        return redirect($order->xendit_payment_url);
    
    } catch (\Exception $e) {
        Log::error("Error saat membuat invoice Xendit: " . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat invoice pembayaran.');
    }
}
}