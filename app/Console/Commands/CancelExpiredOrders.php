<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';

    protected $description = 'Batalkan order yang belum dibayar dan sudah lewat waktu expired';

    public function handle()
    {
        $updatedCount = Order::where('order_status', 'Belum Bayar')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', Carbon::now())
            ->update(['order_status' => 'Dibatalkan']);

        $this->info("$updatedCount order dibatalkan.");

        return 0;
    }
}
