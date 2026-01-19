<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mitra extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'tb_data_mitra';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_mitra';

    /**
     * Kolom yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'nama_mitra',
        'kontak',
        'alamat_mitra',
    ];

    /**
     * Relasi: Mitra memiliki banyak Pemesanan
     */
    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class, 'id_mitra', 'id_mitra');
    }
}
