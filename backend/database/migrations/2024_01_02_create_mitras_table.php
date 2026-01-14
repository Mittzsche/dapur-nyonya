<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Tabel untuk menyimpan data mitra kerja
     */
    public function up(): void
    {
        Schema::create('tb_data_mitra', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->string('nama_mitra', 100);
            $table->string('kontak', 20); // Nomor telepon/WA mitra
            $table->text('alamat_mitra'); // Alamat lengkap mitra
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_mitra');
    }
};
