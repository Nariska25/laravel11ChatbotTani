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

    // Hapus products_id karena sudah tidak ada di tabel carts
    protected $fillable = ['user_id', 'total'];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke semua detail dari cart
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class, 'carts_id', 'carts_id');
    }
 
    // Accessor opsional: menghitung total dari semua subtotal detail
    public function getTotalAttribute()
    {
        return $this->details->sum('subtotal');
    }

    public function updateTotal()
{
    $subtotal = $this->cartDetails()->sum('subtotal');
    $this->subtotal = $subtotal;
    $this->total = $subtotal - $this->discount;
    $this->save();
}
}
