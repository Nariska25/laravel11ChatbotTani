<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'alamat',
        'status',
    ];

    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tipe data yang di-casting
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Nilai default untuk atribut tertentu
    protected $attributes = [
        'status' => 'active',
        'role' => 'user', // Default peran pengguna
    ];

    // Helper method untuk memeriksa peran
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // Relasi ke tabel carts
    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    // Event untuk hashing password sebelum menyimpan
    protected static function booted()
    {
        static::saving(function ($user) {
            if ($user->isDirty('password')) {
                $user->password = bcrypt($user->password);
            }
        });
    }
}
