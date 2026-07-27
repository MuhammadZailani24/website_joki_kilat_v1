<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom file_tugas yang boleh kosong (nullable)
            $table->string('file_tugas')->nullable()->after('deskripsi_tugas');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn('file_tugas');
        });
    }
};