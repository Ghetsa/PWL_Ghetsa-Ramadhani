<?php 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {
    public function run() {
        // Tambah kategori
        DB::table('categories')->insert([
            ['name' => 'Makanan & Minuman'],
            ['name' => 'Kecantikan & Kesehatan'],
            ['name' => 'Perawatan Rumah'],
            ['name' => 'Bayi & Anak'],
        ]);

        // Tambah user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
        ]);

        // Tambah barang
        DB::table('products')->insert([
            ['name' => 'Susu UHT', 'category_id' => 1, 'price' => 15000, 'stock' => 20],
            ['name' => 'Sabun Mandi', 'category_id' => 3, 'price' => 8000, 'stock' => 50],
            ['name' => 'Popok Bayi', 'category_id' => 4, 'price' => 50000, 'stock' => 15],
        ]);

        // Tambah transaksi
        DB::table('transactions')->insert([
            [
                'user_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'total_price' => 30000,
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
                'quantity' => 1,
                'total_price' => 8000,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
