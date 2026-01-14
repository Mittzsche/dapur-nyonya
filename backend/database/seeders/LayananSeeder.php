<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data paket layanan contoh
     */
    public function run(): void
    {
        $layanans = [
            [
                'nama_paket' => 'Paket Nasi Box Ekonomis',
                'harga' => 25000.00,
                'deskripsi' => 'Nasi putih + Ayam goreng/bakar + Tumis sayur + Kerupuk + Sambal + Buah potong. Cocok untuk acara kantor dan rapat.',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Nasi Box Premium',
                'harga' => 45000.00,
                'deskripsi' => 'Nasi putih + Ayam geprek/rendang + Tumis kangkung + Perkedel + Acar + Kerupuk + Sambal + Pudding. Cocok untuk acara pernikahan dan arisan.',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Prasmanan Standard',
                'harga' => 75000.00,
                'deskripsi' => 'Menu prasmanan: Nasi putih, Ayam goreng, Ikan bakar, Tumis sayur, Sambal, Lalapan, Kerupuk, Buah segar. Minimal 50 porsi.',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Prasmanan VIP',
                'harga' => 125000.00,
                'deskripsi' => 'Menu prasmanan lengkap: Nasi putih, Nasi goreng, Ayam bakar madu, Ikan gurame asam manis, Sate ayam, Tumis kangkung, Capcay, Sambal, Es buah, Pudding. Minimal 100 porsi.',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Snack Box',
                'harga' => 15000.00,
                'deskripsi' => 'Isi 3 snack + 1 kue basah + Air mineral. Cocok untuk meeting, seminar, dan workshop.',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Tumpeng Mini',
                'harga' => 150000.00,
                'deskripsi' => 'Tumpeng nasi kuning mini untuk 10 orang, lengkap dengan ayam goreng, telur balado, perkedel, urap, tempe orek, dan emping.',
                'gambar' => null,
            ],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}
