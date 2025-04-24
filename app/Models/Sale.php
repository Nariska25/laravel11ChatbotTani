<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'products_id', 'discount_type', 'discount_value', 
        'start_date', 'end_date', 'status'
    ];

    public function products()
    {
        return $this->belongsTo(Products::class, 'products_id', 'products_id');
    }
}


