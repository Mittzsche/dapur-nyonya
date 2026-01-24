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
            ],
            [
                'key' => 'home_hero_1',
                'value' => '',
                'type' => 'image',
            ],
            [
                'key' => 'home_hero_2',
                'value' => '',
                'type' => 'image',
            ],
            [
                'key' => 'home_tentang_image',
                'value' => '',
                'type' => 'image',
            ],
            [
                'key' => 'home_cara_pemesanan',
                'value' => '',
                'type' => 'image',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@dapurnyonya.com',
                'type' => 'text',
            ],
            [
                'key' => 'contact_address',
                'value' => 'Sukabumi, Jawa Barat, Indonesia',
                'type' => 'text',
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '6281234567890',
                'type' => 'text',
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
