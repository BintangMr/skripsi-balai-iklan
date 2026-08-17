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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            // foreign key yang menyambung ke tabel pemesanans
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->date('tgl_bayar');
            $table->string('bukti_transfer'); // untuk menyimpan nama file gambar
            $table->string('status_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
