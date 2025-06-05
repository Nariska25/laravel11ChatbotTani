<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $primaryKey = 'vouchers_id'; // ✅ Tambahkan ini

    public $incrementing = true; // Opsional, default-nya true
    protected $keyType = 'int';  // Jika tipe datanya integer

    protected $fillable = [
        'promotion_code', 'start_date', 'end_date','quantity', 
        'promotion_type', 'promotion_item', 'discount', 'status',
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
