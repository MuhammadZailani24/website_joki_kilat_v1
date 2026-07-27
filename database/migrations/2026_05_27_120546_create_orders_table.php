<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perintah untuk membuat tabel orders.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (siapa yang memesan)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Data Pesanan
            $table->string('jenjang'); // SD, SMP, SMA, Kuliah
            $table->string('kategori_layanan'); // Tugas Makalah, Aplikasi Web, dll
            $table->text('deskripsi_tugas'); // Detail lengkap tugasnya
            $table->date('deadline'); // Tanggal harus selesai
            $table->string('status')->default('Pending'); // Status: Pending, Proses, Selesai
            
            $table->timestamps();
        });
    }

    /**
     * Jalankan perintah untuk menghapus tabel.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};