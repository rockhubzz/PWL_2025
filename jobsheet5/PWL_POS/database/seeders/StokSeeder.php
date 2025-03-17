<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'stok_id' => 1,
                'barang_id' => 2,
                'user_id' => 2,
                'stok_tanggal' => '2025-03-05 22:23:42',
                'stok_jumlah' => 32
            ],
            [
                'stok_id' => 2,
                'barang_id' => 4,
                'user_id' => 3,
                'stok_tanggal' => '2025-03-06 10:15:30',
                'stok_jumlah' => 20
            ],
            [
                'stok_id' => 3,
                'barang_id' => 6,
                'user_id' => 1,
                'stok_tanggal' => '2025-03-07 14:45:12',
                'stok_jumlah' => 50
            ],
            [
                'stok_id' => 4,
                'barang_id' => 8,
                'user_id' => 3,
                'stok_tanggal' => '2025-03-08 08:10:50',
                'stok_jumlah' => 15
            ],
            [
                'stok_id' => 5,
                'barang_id' => 10,
                'user_id' => 2,
                'stok_tanggal' => '2025-03-09 12:00:00',
                'stok_jumlah' => 60
            ],
            [
                'stok_id' => 6,
                'barang_id' => 1,
                'user_id' => 2,
                'stok_tanggal' => '2025-03-10 18:30:25',
                'stok_jumlah' => 40
            ],
            [
                'stok_id' => 7,
                'barang_id' => 3,
                'user_id' => 3,
                'stok_tanggal' => '2025-03-11 09:20:35',
                'stok_jumlah' => 25
            ],
            [
                'stok_id' => 8,
                'barang_id' => 5,
                'user_id' => 1,
                'stok_tanggal' => '2025-03-12 16:50:45',
                'stok_jumlah' => 30
            ],
            [
                'stok_id' => 9,
                'barang_id' => 7,
                'user_id' => 1,
                'stok_tanggal' => '2025-03-13 11:40:15',
                'stok_jumlah' => 10
            ],
            [
                'stok_id' => 10,
                'barang_id' => 9,
                'user_id' => 3,
                'stok_tanggal' => '2025-03-14 07:55:05',
                'stok_jumlah' => 45
            ],
        ];
        
        DB::table('t_stok')->insert($data);
    }
}
