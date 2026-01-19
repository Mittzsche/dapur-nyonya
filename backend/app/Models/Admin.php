<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Nama tabel di database
     */
    protected $table = 'tb_data_admin';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_admin';

    /**
     * Kolom yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
