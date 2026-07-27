<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenjang',
        'kategori_layanan',
        'institusi',
        'judul_tugas',
        'deskripsi_tugas',
        'catatan_revisi',
        'file_tugas',
        'catatan_tambahan',
        'layanan_tambahan',
        'fitur_aplikasi',   // Tambahan baru App
        'referensi_desain', // Tambahan baru App
        'budget_project',   // Tambahan baru App
        'deadline',
        'status',
        'total_harga',
        'bukti_pembayaran',
        'file_hasil',
    ];

    protected $casts = [
        'layanan_tambahan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // (Tambahkan kode ini di bawah fungsi user() yang sudah ada)
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Relasi Chat
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}