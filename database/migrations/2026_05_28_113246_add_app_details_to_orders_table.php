<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('fitur_aplikasi')->nullable()->after('catatan_tambahan');
            $table->string('referensi_desain')->nullable()->after('fitur_aplikasi');
            $table->bigInteger('budget_project')->nullable()->after('referensi_desain');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['fitur_aplikasi', 'referensi_desain', 'budget_project']);
        });
    }
};