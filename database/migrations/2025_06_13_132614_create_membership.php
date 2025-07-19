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
        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('pelatih_id')->nullable()->constrained('pelatih')->onDelete('set null'); // Opsional, buat nullable
            $table->foreignId('paket_id')->nullable()->constrained('paket')->onDelete('set null');   // Opsional (hanya untuk bulanan), buat nullable

            $table->string('kategori'); // e.g., 'Gym'
            $table->string('sub_kategori'); // e.g., 'Privat', 'Harian', 'Bulanan'

            $table->date('tgl_datang')->nullable(); // Hanya untuk 'Harian', buat nullable
            $table->date('tgl_mulai')->nullable();  // Hanya untuk 'Bulanan', buat nullable
            $table->date('tgl_selesai')->nullable(); // Hanya untuk 'Bulanan', buat nullable

            // Kolom 'paket' (string) dan 'jadwal' (string) TIDAK DITAMBAHKAN di sini.

            $table->string('bukti_bayar')->nullable(); // Bukti pembayaran bisa kosong
            $table->string('status')->default('belum lunas'); // Status pembayaran, default 'belum lunas'
            $table->boolean('status_selesai')->default(false);

            $table->boolean('accepted_trainer')->nullable(); // Menandakan apakah pelatih telah menerima permintaan ini
            $table->text('reason')->nullable(); // Keterangan tambahan, bisa kosong

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};