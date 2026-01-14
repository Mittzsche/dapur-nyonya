<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat akun admin default
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'), // Password default, ganti setelah deploy
            'nama_lengkap' => 'Administrator Dapur Nyonya',
        ]);
    }
}
