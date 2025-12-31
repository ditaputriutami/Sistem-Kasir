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
        // Update detail_beli table to match new structure (detil_pembelian)
        Schema::table('detail_beli', function (Blueprint $table) {
            // Rename jumlah menjadi quantity
            $table->renameColumn('jumlah', 'quantity');
            // Rename harga_beli menjadi harga
            $table->renameColumn('harga_beli', 'harga');
            // Hapus kolom subtotal
            $table->dropColumn('subtotal');
        });

        Schema::table('detail_beli', function (Blueprint $table) {
            // Ubah quantity menjadi INT
            $table->integer('quantity')->change();
            // Ubah harga menjadi INT
            $table->integer('harga')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_beli', function (Blueprint $table) {
            $table->decimal('subtotal', 15, 2)->after('harga');
            $table->renameColumn('quantity', 'jumlah');
            $table->renameColumn('harga', 'harga_beli');
        });
    }
};
