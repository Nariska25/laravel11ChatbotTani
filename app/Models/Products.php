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

    public function cartDetails()
    {
         return $this->hasMany(CartDetail::class, 'products_id', 'products_id');
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
    
        public function activeSale()
        {
            return $this->hasOne(Sale::class, 'products_id', 'products_id')->where('status', 'active')->latest();
        }
    
        public function getDiscountedPriceAttribute()
        {
            if ($this->activeSale && $this->activeSale->discount_value > 0) {
                return max($this->price - $this->activeSale->discount_value, 0);
            }
            return $this->price;
        }

}
