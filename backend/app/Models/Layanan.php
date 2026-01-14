<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'tb_data_layanan';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_layanan';

    /**
     * Kolom yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'nama_paket',
        'harga',
        'deskripsi',
        'gambar',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Relasi: Layanan memiliki banyak Pemesanan
     */
    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_layanan', 'id_layanan');
    }
}
