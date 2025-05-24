<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $table = 'carts_detail'; // Nama tabel di database

    protected $primaryKey = 'carts_detail_id'; // Primary key tabel

    protected $fillable = [
        'carts_id',
        'products_id',
        'amount',
        'subtotal',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'carts_id', 'carts_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id', 'products_id');
    }
}
