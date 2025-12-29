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
        Schema::create('beli', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur')->unique(); // Nomor faktur unik, auto-generated
            $table->date('tanggal'); // Tanggal pembelian
            $table->foreignId('pemasok_id')->constrained('pemasok')->onDelete('cascade'); // Foreign key ke tabel pemasok
            $table->decimal('total', 15, 2)->default(0); // Total pembelian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beli');
    }
};
