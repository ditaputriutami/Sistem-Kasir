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
        // Rename pemasok table columns to match new structure (distributor)
        Schema::table('pemasok', function (Blueprint $table) {
            // Ubah nama_pemasok menjadi VARCHAR(100)
            $table->string('nama_pemasok', 100)->change();
            // Ubah alamat menjadi VARCHAR(100)
            $table->string('alamat', 100)->change();
            // Rename no_telepon menjadi tlp dengan VARCHAR(50)
            $table->renameColumn('no_telepon', 'tlp');
        });

        Schema::table('pemasok', function (Blueprint $table) {
            $table->string('tlp', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasok', function (Blueprint $table) {
            $table->renameColumn('tlp', 'no_telepon');
            $table->text('alamat')->change();
            $table->string('nama_pemasok')->change();
        });
    }
};
