<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;

class MitraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data mitra contoh
     */
    public function run(): void
    {
        $mitras = [
            [
                'nama_mitra' => 'Catering Sukabumi Jaya',
                'kontak' => '081234567890',
                'alamat_mitra' => 'Jl. Sukabumi Raya No. 10, Sukabumi',
            ],
            [
                'nama_mitra' => 'Dapur Ibu Catering',
                'kontak' => '082345678901',
                'alamat_mitra' => 'Jl. Ahmad Yani No. 25, Sukabumi',
            ],
            [
                'nama_mitra' => 'Berkah Catering Service',
                'kontak' => '083456789012',
                'alamat_mitra' => 'Jl. Sudirman No. 15, Sukabumi',
            ],
        ];

        foreach ($mitras as $mitra) {
            Mitra::create($mitra);
        }
    }
}
