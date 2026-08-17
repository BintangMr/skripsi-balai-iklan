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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            // foreign key yang menyambung ke tabel pelanggans (Relasi 1 ke Banyak)
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->date('tgl_pesan');
            $table->enum('jenis_iklan', ['Baris', 'Display']);
            $table->text('materi_iklan');
            $table->float('qty_atau_ukuran');
            $table->decimal('total_biaya', 15, 2);
            $table->string('status'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
