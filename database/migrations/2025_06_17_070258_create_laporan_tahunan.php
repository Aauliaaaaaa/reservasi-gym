<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_tahunan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique(); // Hanya boleh ada satu laporan per tahun
            $table->decimal('total_pendapatan', 15, 2)->default(0); // Untuk menyimpan angka besar (uang)
            $table->integer('jumlah_member_baru')->default(0);
            $table->integer('total_member_aktif')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tahunan');
    }
};
