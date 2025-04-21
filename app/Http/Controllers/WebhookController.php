<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleXenditWebhook(Request $request)
    {
        // Mendapatkan token dari header request
        $token = $request->header('X-CALLBACK-TOKEN');

        // Mengambil expected token dari file konfigurasi
        $expectedToken = config('services.xendit.callback_token');

        // Log token yang diterima dan token yang diharapkan untuk debugging
        Log::info('Token yang diterima dari header: ' . $token);
        Log::info('Token yang diharapkan: ' . $expectedToken);

        // Validasi token
        if ($token !== $expectedToken) {
            Log::warning('Token tidak valid');
            return response()->json(['message' => 'Invalid token'], 403);
        }

        // Log data webhook untuk melihat isi request
        Log::info('Xendit Webhook diterima:', $request->all());

        // Ambil data invoice dan status dari request
        $invoiceId = $request->input('id');
        $status = $request->input('status');

        // Cari order berdasarkan invoice_id
        $order = Order::where('xendit_invoice_id', $invoiceId)->first();

        if ($order) {
            // Update status order berdasarkan status pembayaran
            if ($status === 'PAID') {
                $order->order_status = 'Sudah Bayar';
            } elseif ($status === 'EXPIRED') {
                $order->order_status = 'Kadaluarsa';
            } elseif ($status === 'FAILED') {
                $order->order_status = 'Gagal';
            }

            // Simpan perubahan status
            $order->save();
            Log::info("Order {$order->order_id} diupdate menjadi: {$order->order_status}");
        } else {
            // Jika order tidak ditemukan
            Log::warning("Order tidak ditemukan untuk invoice_id: $invoiceId");
        }

        // Mengembalikan response sukses
        return response()->json(['status' => 'ok']);
    }
}