<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $primaryKey = 'vouchers_id'; // ✅ tambahkan baris ini
    public $incrementing = true; // (opsional, default true, tapi pastikan)
    protected $keyType = 'int';  // (opsional, kalau ID-nya integer)

    protected $fillable = [
        'promotion_code', 'start_date', 'end_date', 'start_time', 
        'quantity', 'promotion_type', 'promotion_item', 'discount', 
    ];

    public function isValid()
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now && $this->use_quantity > 0;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'vouchers_id');
    }
}
