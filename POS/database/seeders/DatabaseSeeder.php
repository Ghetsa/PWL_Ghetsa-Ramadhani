<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tambah kategori
        DB::table('categories')->insert([
            ['name' => 'Makanan & Minuman'],
            ['name' => 'Kecantikan & Kesehatan'],
            ['name' => 'Perawatan Rumah'],
            ['name' => 'Bayi & Anak'],
        ]);

        // Tambah user
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@pos.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ghetsa Ramadhani Riska Arryanti',
                'email' => 'ghetsa@gmail.com',
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'password' => Hash::make('budi123'),
            ],
            [
                'name' => 'Ayu Lestari',
                'email' => 'ayu@gmail.com',
                'password' => Hash::make('ayu123'),
            ],
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
