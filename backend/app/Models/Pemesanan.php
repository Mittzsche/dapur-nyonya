<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'tb_data_pemesanan';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_pemesanan';

    /**
     * Kolom yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'nama_pelanggan',
        'no_hp',
        'alamat',
        'tanggal_acara',
        'catatan',
        'status',
        'id_mitra',
        'id_layanan',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_acara' => 'date',
    ];

    /**
     * Status pemesanan yang tersedia
     */
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    const STATUS_DIBATALKAN = 'dibatalkan';

    /**
     * Relasi: Pemesanan dimiliki oleh satu Mitra
     */
    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'id_mitra', 'id_mitra');
    }

    /**
     * Relasi: Pemesanan dimiliki oleh satu Layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    /**
     * Scope: Filter pesanan dengan status menunggu
     */
    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    /**
     * Scope: Filter pesanan dengan status dikonfirmasi
     */
    public function scopeDikonfirmasi($query)
    {
        return $query->where('status', self::STATUS_DIKONFIRMASI);
    }

    /**
     * Scope: Filter pesanan dengan status dibatalkan
     */
    public function scopeDibatalkan($query)
    {
        return $query->where('status', self::STATUS_DIBATALKAN);
    }
}
