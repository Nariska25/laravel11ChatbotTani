<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Voucher;
use Carbon\Carbon;

class DisableExpiredVouchers extends Command
{
    protected $signature = 'vouchers:disable-expired';
    protected $description = 'Disable vouchers that are expired';

    public function handle()
    {
        $now = Carbon::now();

        $affected = Voucher::where('expired_at', '<', $now)
                    ->where('status', 1) // hanya yang aktif saja
                    ->update(['status' => 0]);

        $this->info("Disabled $affected expired vouchers.");
    }
}
