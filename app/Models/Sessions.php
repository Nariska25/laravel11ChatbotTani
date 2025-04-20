<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSession extends Model // Hindari konflik dengan Laravel
{
    use HasFactory;

    protected $table = 'sessions'; // Pastikan tabelnya benar

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // Sesuaikan dengan primary key users
    }
}
