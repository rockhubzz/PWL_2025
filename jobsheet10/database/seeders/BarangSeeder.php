<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 2,
                'barang_kode' => '1',
                'barang_nama' => 'Pembersih Lantai',
                'harga_beli' => 20000,
                'harga_jual' => 30000
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => '2',
                'barang_nama' => 'Roti Tawar',
                'harga_beli' => 10000,
                'harga_jual' => 15000
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3,
                'barang_kode' => '3',
                'barang_nama' => 'Obat Batuk',
                'harga_beli' => 25000,
                'harga_jual' => 35000
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 1,
                'barang_kode' => '4',
                'barang_nama' => 'Susu UHT',
                'harga_beli' => 12000,
                'harga_jual' => 18000
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 2,
                'barang_kode' => '5',
                'barang_nama' => 'Detergen',
                'harga_beli' => 18000,
                'harga_jual' => 28000
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => '6',
                'barang_nama' => 'Vitamin C',
                'harga_beli' => 15000,
                'harga_jual' => 22000
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 1,
                'barang_kode' => '7',
                'barang_nama' => 'Kopi Instan',
                'harga_beli' => 5000,
                'harga_jual' => 10000
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 2,
                'barang_kode' => '8',
                'barang_nama' => 'Lap Pel',
                'harga_beli' => 15000,
                'harga_jual' => 22000
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 3,
                'barang_kode' => '9',
                'barang_nama' => 'Obat Sakit Kepala',
                'harga_beli' => 30000,
                'harga_jual' => 45000
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 1,
                'barang_kode' => '10',
                'barang_nama' => 'Mie Instan',
                'harga_beli' => 3000,
                'harga_jual' => 5000
            ],
        ];
        
        DB::table('m_barang')->insert($data);
    }
}
