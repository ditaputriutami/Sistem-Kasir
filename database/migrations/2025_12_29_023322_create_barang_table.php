<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique(); // Kode barang unik
            $table->string('nama_barang'); // Nama barang
            $table->integer('stok')->default(0); // Stok barang, default 0
            $table->string('satuan'); // Satuan (pcs, kg, box, dll)
            $table->decimal('harga_beli', 15, 2); // Harga beli
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
