<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'penjualan_id' => 1,
                'user_id' => 3,
                'pembeli' => 'raki',
                'penjualan_kode' => 1,
                'penjualan_tanggal' => '2025-03-05 07:00:00'
            ],
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'budi',
                'penjualan_kode' => 2,
                'penjualan_tanggal' => '2025-03-05 08:00:00'
            ],
            [
                'penjualan_id' => 3,
                'user_id' => 1,
                'pembeli' => 'siti',
                'penjualan_kode' => 3,
                'penjualan_tanggal' => '2025-03-05 09:00:00'
            ],
            [
                'penjualan_id' => 4,
                'user_id' => 3,
                'pembeli' => 'agus',
                'penjualan_kode' => 4,
                'penjualan_tanggal' => '2025-03-05 10:00:00'
            ],
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'dina',
                'penjualan_kode' => 5,
                'penjualan_tanggal' => '2025-03-05 11:00:00'
            ],
            [
                'penjualan_id' => 6,
                'user_id' => 1,
                'pembeli' => 'erik',
                'penjualan_kode' => 6,
                'penjualan_tanggal' => '2025-03-05 12:00:00'
            ],
            [
                'penjualan_id' => 7,
                'user_id' => 3,
                'pembeli' => 'fina',
                'penjualan_kode' => 7,
                'penjualan_tanggal' => '2025-03-05 13:00:00'
            ],
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'gina',
                'penjualan_kode' => 8,
                'penjualan_tanggal' => '2025-03-05 14:00:00'
            ],
            [
                'penjualan_id' => 9,
                'user_id' => 1,
                'pembeli' => 'hadi',
                'penjualan_kode' => 9,
                'penjualan_tanggal' => '2025-03-05 15:00:00'
            ],
            [
                'penjualan_id' => 10,
                'user_id' => 3,
                'pembeli' => 'indah',
                'penjualan_kode' => 10,
                'penjualan_tanggal' => '2025-03-05 16:00:00'
            ],
        ];
        
        DB::table('t_penjualan')->insert($data);
    }
}
