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
        Schema::create('detail_beli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beli_id')->constrained('beli')->onDelete('cascade'); // Foreign key ke tabel beli
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade'); // Foreign key ke tabel barang
            $table->integer('jumlah'); // Jumlah barang yang dibeli
            $table->decimal('harga_beli', 15, 2); // Harga beli per unit
            $table->decimal('subtotal', 15, 2); // Subtotal (jumlah x harga_beli)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_beli');
    }
};
