<?php

namespace Database\Seeders;

use App\Models\Pemasok;
use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemasokData = [
            [
                'kode_pemasok' => 'PMS0001',
                'nama_pemasok' => 'PT. Sumber Jaya',
                'alamat' => 'Jl. Raya Bekasi No. 123, Jakarta Timur',
                'no_telepon' => '021-8765432'
            ],
            [
                'kode_pemasok' => 'PMS0002',
                'nama_pemasok' => 'CV. Maju Makmur',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'no_telepon' => '022-7654321'
            ],
            [
                'kode_pemasok' => 'PMS0003',
                'nama_pemasok' => 'Toko Grosir Sejahtera',
                'alamat' => 'Jl. Ahmad Yani No. 78, Surabaya',
                'no_telepon' => '031-8765432'
            ],
        ];

        foreach ($pemasokData as $data) {
            Pemasok::create($data);
        }
    }
}
