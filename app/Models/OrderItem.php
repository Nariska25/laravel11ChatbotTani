<?php
// app/Models/OrderItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Order;


class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_item_id';
    protected $fillable = [
        'order_id',
        'products_id',
        'products_name',
        'amount',
        'price',
        'subtotal',
        'discount',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }
}