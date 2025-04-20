<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'products_id';  // Pastikan kolom primary key sesuai
    public $incrementing = true; // Pastikan ini benar jika ID bertipe integer auto-increment
    protected $keyType = 'int';

    protected $fillable = [ 
        'products_name', 
        'price', 
        'stock', 
        'products_description', 
        'products_image', 
        'category_id', 
        'recommendation', 
    ];

    // Relasi ke kategori
    
        // App\Models\Products.php
        public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'products_id', 'products_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'products_id', 'products_id');
    }

        public function hasDiscount()
        {
            return $this->original_price > $this->price; // Mengecek apakah ada selisih harga
        }

    public function sale()
    {
        return $this->hasOne(Sale::class, 'products_id', 'products_id')->latest();
    }

        public function orders() {
            return $this->hasMany(Order::class);
        }
        


        // Hitung harga setelah diskon
        public function getDiscountedPriceAttribute()
        {
            $sale = $this->sale; // Mengambil satu data sale terbaru
            if ($sale && $sale->status == 'active') {
                if ($sale->discount_type == 'percentage') {
                    return $this->price - ($this->price * ($sale->discount_value / 100));
                } elseif ($sale->discount_type == 'fixed') {
                    return max(0, $this->price - $sale->discount_value);
                }
            }
            return $this->price; // Harga normal jika tidak ada sale
        }
}
