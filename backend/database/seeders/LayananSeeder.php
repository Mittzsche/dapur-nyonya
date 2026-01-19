<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = [
            [
                'nama_paket' => 'Paket Senin',
                'harga' => 25000,
                'deskripsi' => 'Nasi Putih, Ayam Bakar Taliwang, Cah Sawi Putih, Buah',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Selasa',
                'harga' => 25000,
                'deskripsi' => 'Nasi Putih, Chicken Katsu, Acar Bento, Yoghurt',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Rabu',
                'harga' => 25000,
                'deskripsi' => 'Nasi Putih, Sate Ayam, Bakwan Jagung, Nutrijel',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Kamis',
                'harga' => 25000,
                'deskripsi' => 'Spaghetti Bolognese, Yakult',
                'gambar' => null,
            ],
            [
                'nama_paket' => 'Paket Jumat',
                'harga' => 25000,
                'deskripsi' => 'Nasi Putih, Ayam Goreng Serundeng, Bening Bayam Janis, Beng-beng',
                'gambar' => null,
            ],
        ];

        foreach ($layanan as $item) {
            DB::table('tb_data_layanan')->updateOrInsert(
                ['nama_paket' => $item['nama_paket']],
                $item
            );
        }
    }
}
