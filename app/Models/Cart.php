<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'carts_id';

    protected $fillable = [
        'produk_id',
        'jumlah',
    ];

    public function produk()
    {
        return $this->belongsTo(Products::class, 'produk_id');
    }
}
