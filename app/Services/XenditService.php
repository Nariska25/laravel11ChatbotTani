<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;


class XenditService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('XENDIT_SECRET_KEY');
    }

    public function createInvoice($order)
    {
        $response = Http::withBasicAuth($this->apiKey, '')
            ->post('https://api.xendit.co/v2/invoices', [
                'external_id' => 'order-' . $order->id,
                'amount' => $order->total_bayar,
                'payer_email' => auth()->user()->email,
                'description' => 'Pembayaran Order #' . $order->id,
                'success_redirect_url' => route('payment.success', $order->id),
                'failure_redirect_url' => route('payment.failed', $order->id),
            ]);

        return $response->json();
    }
}
