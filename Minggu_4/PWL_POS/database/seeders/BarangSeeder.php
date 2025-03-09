<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BABY001', 'barang_nama' => 'Popok Bayi', 'harga_beli' => 40000, 'harga_jual' => 50000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 2, 'kategori_id' => 2, 'barang_kode' => 'BEAUTY001', 'barang_nama' => 'Lipstik', 'harga_beli' => 60000, 'harga_jual' => 75000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 3, 'kategori_id' => 3, 'barang_kode' => 'FOOD001', 'barang_nama' => 'Mi Instan', 'harga_beli' => 2000, 'harga_jual' => 2500, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 4, 'kategori_id' => 4, 'barang_kode' => 'HOME001', 'barang_nama' => 'Sapu Lidi', 'harga_beli' => 15000, 'harga_jual' => 20000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 5, 'kategori_id' => 5, 'barang_kode' => 'ELECT001', 'barang_nama' => 'Lampu LED', 'harga_beli' => 40000, 'harga_jual' => 50000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 6, 'kategori_id' => 1, 'barang_kode' => 'BABY002', 'barang_nama' => 'Pakaian Bayi', 'harga_beli' => 25000, 'harga_jual' => 30000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 7, 'kategori_id' => 2, 'barang_kode' => 'BEAUTY002', 'barang_nama' => 'Shampo', 'harga_beli' => 30000, 'harga_jual' => 40000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 8, 'kategori_id' => 3, 'barang_kode' => 'FOOD002', 'barang_nama' => 'Susu Bubuk', 'harga_beli' => 50000, 'harga_jual' => 60000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 9, 'kategori_id' => 4, 'barang_kode' => 'HOME002', 'barang_nama' => 'Gelas Plastik', 'harga_beli' => 8000, 'harga_jual' => 10000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'ELECT002', 'barang_nama' => 'Charger HP', 'harga_beli' => 20000, 'harga_jual' => 25000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('m_barang')->insert($data);
    }
}
