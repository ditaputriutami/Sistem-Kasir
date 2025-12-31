<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beli extends Model
{
    // Nama tabel
    protected $table = 'beli';

    // Field yang dapat diisi mass assignment
    protected $fillable = [
        'no_faktur',
        'tanggal',
        'pemasok_id',
        'jumlah_pembelian'
    ];

    // Cast tanggal ke format date
    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi ke Pemasok (Many to One)
     * Banyak transaksi pembelian milik satu pemasok
     */
    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class);
    }

    /**
     * Relasi ke DetailBeli (One to Many)
     * Satu transaksi pembelian memiliki banyak detail
     */
    public function detailBeli()
    {
        return $this->hasMany(DetailBeli::class);
    }

    /**
     * Generate nomor faktur otomatis
     * Format: BL-YYYYMMDD-XXXX
     */
    public static function generateNoFaktur()
    {
        $tanggal = date('Ymd');
        $prefix = 'BL-' . $tanggal . '-';

        // Cari nomor faktur terakhir pada hari ini
        $lastFaktur = self::where('no_faktur', 'like', $prefix . '%')
            ->orderBy('no_faktur', 'desc')
            ->first();

        if ($lastFaktur) {
            // Ambil 4 digit terakhir dan tambahkan 1
            $lastNumber = intval(substr($lastFaktur->no_faktur, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format dengan 4 digit (contoh: 0001, 0002, dst)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
