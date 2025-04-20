<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id', 'discount_type', 'discount_value', 
        'start_date', 'end_date', 'status'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'produk_id', 'produk_id');
    }
}


