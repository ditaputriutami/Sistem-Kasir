<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user admin default untuk login
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@kasir.com',
            'password' => Hash::make('admin123'),
        ]);

        // Buat user kasir
        User::create([
            'name' => 'Kasir 1',
            'username' => 'kasir',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('kasir123'),
        ]);

        // Seed data pemasok
        $this->call([
            PemasokSeeder::class,
        ]);
    }
}
