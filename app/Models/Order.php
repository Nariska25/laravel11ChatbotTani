<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'user_id',
        'shipping_methods_id',
        'vouchers_id',
        'order_status',
        'discount',
        'shipping_cost',
        'total_payment',
        'xendit_invoice_id',
        'xendit_payment_url',
        'external_id',
        'expires_at',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_methods_id');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'vouchers_id');
    }

    // Helper methods for status
    public function isBelumBayar()
    {
        return $this->order_status === 'Belum Bayar';
    }

    public function isTelahDibayar()
    {
        return $this->order_status === 'Telah Dibayar';
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