<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';

    protected $description = 'Batalkan order yang belum dibayar dan sudah lewat 1 hari';

    public function handle()
    {
        $expiredOrders = Order::where('order_status', 'Belum Bayar')
            ->where('expires_at', '<', Carbon::now())
            ->get();

        foreach ($expiredOrders as $order) {
            $order->order_status = 'Dibatalkan';
            $order->save();

            $this->info("Order {$order->order_id} dibatalkan.");
        }

        return 0;
    }
}
