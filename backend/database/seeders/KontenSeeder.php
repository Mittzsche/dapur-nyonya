<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konten;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kontenData = [
            [
                'key' => 'home_logo',
                'value' => '', // Akan diisi via admin panel
                'type' => 'image',
                'description' => 'Logo website di halaman home (dalam lingkaran merah)'
            ],
            [
                'key' => 'home_hero_1',
                'value' => '',
                'type' => 'image',
                'description' => 'Banner hero 1 di halaman home'
            ],
            [
                'key' => 'home_hero_2',
                'value' => '',
                'type' => 'image',
                'description' => 'Banner hero 2 di halaman home'
            ],
            [
                'key' => 'home_tentang_image',
                'value' => '',
                'type' => 'image',
                'description' => 'Gambar di section Tentang Kami'
            ],
            [
                'key' => 'home_cara_pemesanan',
                'value' => '',
                'type' => 'image',
                'description' => 'Gambar panduan cara pemesanan'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'description' => 'Nomor telepon kontak'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@dapurnyonya.com',
                'type' => 'text',
                'description' => 'Email kontak'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Sukabumi, Jawa Barat, Indonesia',
                'type' => 'text',
                'description' => 'Alamat lengkap'
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'type' => 'text',
                'description' => 'Nomor WhatsApp untuk pemesanan'
            ],
        ];

        foreach ($kontenData as $data) {
            Konten::updateOrCreate(
                ['key' => $data['key']],
                $data
            );
        }

        $this->command->info('Konten default berhasil di-seed!');
    }
}
