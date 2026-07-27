<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'pesan', 'lampiran'];

    // Relasi ke User (Pengirim)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}