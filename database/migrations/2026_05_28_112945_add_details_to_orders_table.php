<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('institusi')->nullable()->after('kategori_layanan');
            $table->string('judul_tugas')->nullable()->after('institusi');
            $table->text('catatan_tambahan')->nullable()->after('file_tugas');
            $table->json('layanan_tambahan')->nullable()->after('catatan_tambahan'); // Disimpan dalam format JSON karena berupa pilihan ganda (checkbox)
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['institusi', 'judul_tugas', 'catatan_tambahan', 'layanan_tambahan']);
        });
    }
};