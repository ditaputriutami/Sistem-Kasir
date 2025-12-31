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
        // Update beli table to match new structure (pembelian)
        Schema::table('beli', function (Blueprint $table) {
            // Hapus kolom total
            $table->dropColumn('total');
        });

        Schema::table('beli', function (Blueprint $table) {
            // Tambah kolom jumlah_pembelian setelah pemasok_id
            $table->integer('jumlah_pembelian')->default(0)->after('pemasok_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beli', function (Blueprint $table) {
            $table->dropColumn('jumlah_pembelian');
        });

        Schema::table('beli', function (Blueprint $table) {
            $table->decimal('total', 15, 2)->default(0)->after('pemasok_id');
        });
    }
};
