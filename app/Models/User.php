<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nama tabel yang digunakan
    protected $primaryKey = 'user_id'; // Primary key sesuai migration
    public $incrementing = true; // Karena primary key integer manual, bukan auto-increment
    protected $keyType = 'int'; // Tipe primary key integer

    protected $fillable = [
        'user_id', // Tambahkan user_id agar bisa diisi manual
        'name',
        'email',
        'city_id',
        'role',
        'email_verified_at',
        'password',
        'phone',
        'gender',
        'dob',
        'image_path',
        'status',
        'address',
        'city',
        'postal_code',
        'province',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'active', // Nilai default
        'role' => 'user',
    ];

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah user biasa
    public function isUser()
    {
        return $this->role === 'user';
    }

    // Relasi ke tabel orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }

    // Relasi ke tabel carts
    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'user_id');
    }
}