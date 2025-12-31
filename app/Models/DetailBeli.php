<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBeli extends Model
{
    // Nama tabel
    protected $table = 'detail_beli';

    // Field yang dapat diisi mass assignment
    protected $fillable = [
        'beli_id',
        'barang_id',
        'quantity',
        'harga'
    ];

    /**
     * Relasi ke Beli (Many to One)
     * Banyak detail pembelian milik satu transaksi pembelian
     */
    public function beli()
    {
        return $this->belongsTo(Beli::class);
    }

    /**
     * Relasi ke Barang (Many to One)
     * Banyak detail pembelian merujuk ke satu barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Accessor untuk subtotal
     */
    public function getSubtotalAttribute()
    {
        return $this->harga * $this->quantity;
    }
}
