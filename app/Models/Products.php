<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'produk_id';  // Pastikan kolom primary key sesuai
    public $incrementing = true; // Pastikan ini benar jika ID bertipe integer auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'nama_produk', 'deskripsi_produk', 'harga', 'stok', 'kategori_id', 'gambar_produk',
    ];

    // Relasi ke kategori
    
        // App\Models\Products.php
        public function kategori()
        {
            return $this->belongsTo(Categories::class, 'kategori_id');
        }
        
        public function carts()
        {
            return $this->hasMany(Cart::class, 'product_id', 'produk_id');
        }
    
    
}
