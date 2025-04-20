<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'short_description', 'description', 
        'terms_and_conditions', 'promotion_code', 
        'start_date', 'end_date', 'start_time', 
        'use_quantity', 'promotion_type', 'promotion_item', 'special_price'
    ];

    public function isValid()
    {
        $now = Carbon::now();
        return $this->start_date <= $now && $this->end_date >= $now && $this->use_quantity > 0;
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'voucher_id', 'id');
    }
}
