<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 2, 'pembeli' => 'Sari', 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => Carbon::parse('2024-04-01 09:30:00')],
            ['penjualan_id' => 2, 'user_id' => 3, 'pembeli' => 'Tono', 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => Carbon::parse('2024-04-02 14:20:00')],
            ['penjualan_id' => 3, 'user_id' => 1, 'pembeli' => 'Umar', 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => Carbon::parse('2024-04-03 11:45:00')],
            ['penjualan_id' => 4, 'user_id' => 3, 'pembeli' => 'Vina', 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => Carbon::parse('2024-04-04 16:10:00')],
            ['penjualan_id' => 5, 'user_id' => 2, 'pembeli' => 'Wawan', 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => Carbon::parse('2024-04-05 08:00:00')],
            ['penjualan_id' => 6, 'user_id' => 1, 'pembeli' => 'Xenia', 'penjualan_kode' => 'TRX006', 'penjualan_tanggal' => Carbon::parse('2024-04-06 12:30:00')],
            ['penjualan_id' => 7, 'user_id' => 3, 'pembeli' => 'Yusuf', 'penjualan_kode' => 'TRX007', 'penjualan_tanggal' => Carbon::parse('2024-04-07 15:45:00')],
            ['penjualan_id' => 8, 'user_id' => 2, 'pembeli' => 'Zahra', 'penjualan_kode' => 'TRX008', 'penjualan_tanggal' => Carbon::parse('2024-04-08 10:25:00')],
            ['penjualan_id' => 9, 'user_id' => 1, 'pembeli' => 'Bambang', 'penjualan_kode' => 'TRX009', 'penjualan_tanggal' => Carbon::parse('2024-04-09 13:55:00')],
            ['penjualan_id' => 10, 'user_id' => 3, 'pembeli' => 'Cindy', 'penjualan_kode' => 'TRX010', 'penjualan_tanggal' => Carbon::parse('2024-04-10 17:20:00')],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
