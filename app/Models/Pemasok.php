<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    // Nama tabel
    protected $table = 'pemasok';

    // Field yang dapat diisi mass assignment
    protected $fillable = [
        'kode_pemasok',
        'nama_pemasok',
        'alamat',
        'tlp'
    ];

    /**
     * Relasi ke Beli (One to Many)
     * Satu pemasok bisa melakukan banyak transaksi pembelian
     */
    public function beli()
    {
        return $this->hasMany(Beli::class);
    }
}
