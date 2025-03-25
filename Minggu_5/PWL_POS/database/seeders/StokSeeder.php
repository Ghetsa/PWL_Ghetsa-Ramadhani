<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['stok_id' => 1, 'supplier_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 22],
            ['stok_id' => 2, 'supplier_id' => 1, 'barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 13],
            ['stok_id' => 3, 'supplier_id' => 1, 'barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 9],
            ['stok_id' => 4, 'supplier_id' => 2, 'barang_id' => 4, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 7],
            ['stok_id' => 5, 'supplier_id' => 2, 'barang_id' => 5, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 4],
            ['stok_id' => 6, 'supplier_id' => 2, 'barang_id' => 6, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 5],
            ['stok_id' => 7, 'supplier_id' => 3, 'barang_id' => 7, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 2],
            ['stok_id' => 8, 'supplier_id' => 3, 'barang_id' => 8, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 8],
            ['stok_id' => 9, 'supplier_id' => 3, 'barang_id' => 9, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 3],
            ['stok_id' => 10, 'supplier_id' => 3, 'barang_id' => 10, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 27],
        ];

        DB::table('t_stok')->insert($data);
    }
}
