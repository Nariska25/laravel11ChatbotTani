<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'carts_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['user_id', 'products_id', 'amount', 'price', 'discount', 'subtotal', 'total'];

    // Add these accessors
    protected $appends = ['total'];
    
    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Calculate total automatically
    public function getTotalAttribute()
    {
        return ($this->amount * $this->price) - ($this->amount * $this->discount);
    }
}