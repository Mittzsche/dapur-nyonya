<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Tabel untuk menyimpan data pemesanan pelanggan
     */
    public function up(): void
    {
        Schema::create('tb_data_pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->string('nama_pelanggan', 50);
            $table->string('no_hp', 15); // Nomor HP/WA pelanggan
            $table->text('alamat'); // Alamat pengiriman
            $table->date('tanggal_acara');
            $table->text('catatan')->nullable(); // Catatan khusus dari pelanggan
            $table->string('status', 20)->default('menunggu'); // menunggu, dikonfirmasi, dibatalkan

            // Foreign keys
            $table->unsignedBigInteger('id_mitra')->nullable();
            $table->unsignedBigInteger('id_layanan');

            $table->foreign('id_mitra')
                ->references('id_mitra')
                ->on('tb_data_mitra')
                ->onDelete('set null');

            $table->foreign('id_layanan')
                ->references('id_layanan')
                ->on('tb_data_layanan')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_data_pemesanan');
    }
};
