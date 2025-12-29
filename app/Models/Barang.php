<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Nama tabel
    protected $table = 'barang';

    // Field yang dapat diisi mass assignment
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'satuan',
        'harga_beli'
    ];

    /**
     * Relasi ke DetailBeli (One to Many)
     * Satu barang bisa ada di banyak detail pembelian
     */
    public function detailBeli()
    {
        return $this->hasMany(DetailBeli::class);
    }
}
