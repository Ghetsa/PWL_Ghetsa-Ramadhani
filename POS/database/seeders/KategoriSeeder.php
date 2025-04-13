<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'kategori_kode' => 'BABY', 'kategori_nama' => 'Bayi dan Anak'],
            ['kategori_id' => 2, 'kategori_kode' => 'BEAUTY', 'kategori_nama' => 'Kecantikan dan Kesehatan'],
            ['kategori_id' => 3, 'kategori_kode' => 'FOOD', 'kategori_nama' => 'Makanan'],
            ['kategori_id' => 4, 'kategori_kode' => 'HOME', 'kategori_nama' => 'Perlengkapan Rumah'],
            ['kategori_id' => 5, 'kategori_kode' => 'ELECT', 'kategori_nama' => 'Elektronik'],
        ];

        DB::table('m_kategori')->insert($data);
    }
}