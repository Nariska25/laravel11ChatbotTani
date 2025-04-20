<?php
// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'order_status',
        'subtotal',
        'discount',
        'shipping_cost',
        'total_payment',
        'courier',
        'courier_service',
        'delivery_estimate',
        'shipping_address',
        'payment_status',
        'xendit_invoice_id',
        'xendit_payment_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Helper methods for status

    public function isBelumBayar()
    {
        return $this->order_status === 'Belum Bayar';
    }
    
    public function isTelahDibayar()
    {
        return $this->payment_status === 'Telah Dibayar';
    }

    public function isSedangDikemas()
    {
        return $this->order_status === 'Sedang Dikemas';
    }

    public function isDikirim()
    {
        return $this->order_status === 'Dikirim';
    }

    public function isSelesai()
    {
        return $this->order_status === 'Selesai';
    }

    public function isDibatalkan()
    {
        return $this->order_status === 'Dibatalkan';
    }
}