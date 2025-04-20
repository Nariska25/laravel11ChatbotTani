<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class WebhookController extends Controller
{
    public function __construct()
    {
        // Hapus middleware web karena tidak diperlukan untuk webhook
        // $this->middleware('web');
    }

    public function handleXenditWebhook(Request $request)
    {
        try {
            // Validasi token callback
            $expectedToken = config('services.xendit.callback_token');
            if (empty($expectedToken)) {
                throw new \Exception('XENDIT_CALLBACK_TOKEN not configured');
            }

            $token = $request->header('x-callback-token');
            if ($token !== $expectedToken) {
                Log::warning('Invalid webhook token', [
                    'expected' => $expectedToken,
                    'received' => $token,
                    'ip' => $request->ip()
                ]);
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $data = $request->all();
            Log::debug('Xendit Webhook Received:', $data);

            // Validasi payload
            if (!isset($data['external_id'], $data['status'])) {
                throw new \Exception('Invalid webhook payload');
            }

            // Ekstrak order_id dari external_id
            if (!preg_match('/^order-(\d+)$/', $data['external_id'], $matches)) {
                throw new \Exception('Invalid external_id format');
            }

            $orderId = $matches[1];
            $order = Order::find($orderId);

            if (!$order) {
                throw new \Exception("Order {$orderId} not found");
            }

            // Handle status pembayaran
            $this->handleOrderStatus($order, $data['status']);

            return response()->json([
                'success' => true,
                'message' => 'Order updated',
                'order_id' => $orderId,
                'new_status' => $order->order_status
            ]);

        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $request->all()
            ]);
            
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    protected function handleOrderStatus(Order $order, string $status)
    {
        $originalStatus = $order->order_status;
        
        switch ($status) {
            case 'PAID':
                $order->order_status = 'Telah Dibayar';
                break;
            
            case 'EXPIRED':
                $order->order_status = 'Dibatalkan';
                break;
                
            default:
                throw new \Exception("Unhandled status: {$status}");
        }

        $order->save();

        Log::info('Order status updated', [
            'order_id' => $order->id,
            'from' => $originalStatus,
            'to' => $order->order_status,
            'xendit_status' => $status
        ]);
    }
}