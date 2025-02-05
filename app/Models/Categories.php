<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $primaryKey = 'kategori_id'; // Kolom primary key
    protected $fillable = ['nama_kategori']; // Kolom yang dapat diisi massal

    // Relasi ke produk
    public function products()
    {
        return $this->hasMany(Products::class, 'kategori_id', 'kategori_id');
    }
}

