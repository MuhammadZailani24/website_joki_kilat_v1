<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    // Mengizinkan pengisian data massal untuk kolom-kolom ini
    protected $fillable = ['nama_layanan', 'kategori', 'harga', 'deskripsi'];
}