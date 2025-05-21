<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'shipping_methods';
    protected $primaryKey = 'shipping_methods_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'courier',
        'courier_service',
        'delivery_estimate',
        'cost',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cost' => 'float',
    ];
}