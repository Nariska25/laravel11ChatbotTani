<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id'; // Ubah sesuai dengan nama kolom di database
    public $incrementing = true; 
    protected $keyType = 'int'; 
    public $timestamps = true; 

    protected $fillable = ['category_name'];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id', 'category_id');
    }
}