<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Tabel untuk menyimpan data layanan/paket catering
     */
    public function up(): void
    {
        Schema::create('tb_data_layanan', function (Blueprint $table) {
            $table->id('id_layanan');
            $table->string('nama_paket', 100);
            $table->decimal('harga', 10, 2); // Harga dalam Rupiah
            $table->text('deskripsi'); // Rincian isi paket
            $table->string('gambar')->nullable(); // Path gambar paket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_layanan');
    }
};
