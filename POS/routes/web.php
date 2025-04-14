<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/level', [LevelController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/stok', [StokController::class, 'index']);
Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan_detail', [PenjualanDetailController::class, 'index']);


// Praktikum 2 - Langkah 5
Route::get('/', [WelcomeController::class, 'index']);

// Praktikum 3 - Langkah 3 &  JS6 - Praktikum 1 - Langkah 6
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']); // Menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // Menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // Menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // Menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
    Route::get('/{id}', [UserController::class, 'show']); // Menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // Menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // Menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // Menghapus data user
});

//Level
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); // Menampilkan halaman awal Level
    Route::post('/list', [LevelController::class, 'list']); // Menampilkan data Level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']); // Menampilkan halaman form tambah Level
    Route::post('/', [LevelController::class, 'store']); // Menyimpan data Level baru
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah Level Ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data Level baru Ajax
    Route::get('/{id}', [LevelController::class, 'show']); // Menampilkan detail Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // Menampilkan halaman form edit Level
    Route::put('/{id}', [LevelController::class, 'update']); // Menyimpan perubahan data Level
    Route::delete('/{id}', [LevelController::class, 'destroy']); // Menghapus data Level
});

//Kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); // Menampilkan halaman awal Kategori
    Route::post('/list', [KategoriController::class, 'list']); // Menampilkan data Kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']); // Menampilkan halaman form tambah Kategori
    Route::post('/', [KategoriController::class, 'store']); // Menyimpan data Kategori baru
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah Kategori Ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data Kategori baru Ajax
    Route::get('/{id}', [KategoriController::class, 'show']); // Menampilkan detail Kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // Menampilkan halaman form edit Kategori
    Route::put('/{id}', [KategoriController::class, 'update']); // Menyimpan perubahan data Kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // Menghapus data Kategori
});

//Supplier
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']); // Menampilkan halaman awal Supplier
    Route::post('/list', [SupplierController::class, 'list']); // Menampilkan data Supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']); // Menampilkan halaman form tambah Supplier
    Route::post('/', [SupplierController::class, 'store']); // Menyimpan data Supplier baru
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data Supplier baru Ajax
    Route::get('/{id}', [SupplierController::class, 'show']); // Menampilkan detail Supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Menampilkan halaman form edit Supplier
    Route::put('/{id}', [SupplierController::class, 'update']); // Menyimpan perubahan data Supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // Menghapus data Supplier
});

//Barang
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']); // Menampilkan halaman awal Barang
    Route::post('/list', [BarangController::class, 'list']); // Menampilkan data Barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']); // Menampilkan halaman form tambah Barang
    Route::post('/', [BarangController::class, 'store']); // Menyimpan data Barang baru
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah Barang Ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data Barang baru Ajax
    Route::get('/{id}', [BarangController::class, 'show']); // Menampilkan detail Barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // Menampilkan halaman form edit Barang
    Route::put('/{id}', [BarangController::class, 'update']); // Menyimpan perubahan data Barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); // Menghapus data Barang
});

//Stok
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']); // Menampilkan halaman awal Stok
    Route::post('/list', [StokController::class, 'list']); // Menampilkan data Stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']); // Menampilkan halaman form tambah Stok
    Route::post('/', [StokController::class, 'store']); // Menyimpan data Stok baru
    Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Menampilkan halaman form tambah Stok Ajax
    Route::post('/ajax', [StokController::class, 'store_ajax']); // Menyimpan data Stok baru Ajax
    Route::get('/{id}', [StokController::class, 'show']); // Menampilkan detail Stok
    Route::get('/{id}/edit', [StokController::class, 'edit']); // Menampilkan halaman form edit Stok
    Route::put('/{id}', [StokController::class, 'update']); // Menyimpan perubahan data Stok
    Route::delete('/{id}', [StokController::class, 'destroy']); // Menghapus data Stok
});

//Penjualan
Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']); // Menampilkan halaman awal Penjualan
    Route::post('/list', [PenjualanController::class, 'list']); // Menampilkan data Penjualan dalam bentuk json untuk datatables
    Route::get('/create', [PenjualanController::class, 'create']); // Menampilkan halaman form tambah Penjualan
    Route::post('/', [PenjualanController::class, 'store']); // Menyimpan data Penjualan baru
    Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']); // Menampilkan halaman form tambah Penjualan Ajax
    Route::post('/ajax', [PenjualanController::class, 'store_ajax']); // Menyimpan data Penjualan baru Ajax
    Route::get('/{id}', [PenjualanController::class, 'show']); // Menampilkan detail Penjualan
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']); // Menampilkan halaman form edit Penjualan
    Route::put('/{id}', [PenjualanController::class, 'update']); // Menyimpan perubahan data Penjualan
    Route::delete('/{id}', [PenjualanController::class, 'destroy']); // Menghapus data Penjualan
});



// Route::get('/user/{id}/name/{name}', [UserController::class, 'user']); // Halaman User
// Route::get('/penjualan', [PenjualanController::class, 'penjualan']);

// Route::get('/', [HomeController::class,'home'])->name('home'); // Halaman Home

// // Halaman Products
// Route::prefix('category')->group(function() {
//     Route::get('/food-beverage', [ProductsController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductsController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductsController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductsController::class, 'babyKid']);
// });

// Route::get('/products', function () {
//     return view('products');
// });

// Route::get('/', function () {
//     return view('welcome');
// });

//===================================
//| JOBSHEET 4 - PRAKTIKUM 2.6 CRUD |
//===================================
// User
// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Level
// Route::get('/level/tambah', [LevelController::class, 'tambah']);
// Route::post('/level/tambah_simpan', [LevelController::class, 'tambah_simpan']);
// Route::get('/level/ubah/{id}', [LevelController::class, 'ubah']);
// Route::put('/level/ubah_simpan/{id}', [LevelController::class, 'ubah_simpan']);
// Route::get('/level/hapus/{id}', [LevelController::class, 'hapus']);

// // Kategori
// Route::get('/kategori/tambah', [KategoriController::class, 'tambah']);
// Route::post('/kategori/tambah_simpan', [KategoriController::class, 'tambah_simpan']);
// Route::get('/kategori/ubah/{id}', [KategoriController::class, 'ubah']);
// Route::put('/kategori/ubah_simpan/{id}', [KategoriController::class, 'ubah_simpan']);
// Route::get('/kategori/hapus/{id}', [KategoriController::class, 'hapus']);

// // Supplier
// Route::get('/supplier/tambah', [SupplierController::class, 'tambah']);
// Route::post('/supplier/tambah_simpan', [SupplierController::class, 'tambah_simpan']);
// Route::get('/supplier/ubah/{id}', [SupplierController::class, 'ubah']);
// Route::put('/supplier/ubah_simpan/{id}', [SupplierController::class, 'ubah_simpan']);
// Route::get('/supplier/hapus/{id}', [SupplierController::class, 'hapus']);

// // Barang
// Route::get('/barang/tambah', [BarangController::class, 'tambah']);
// Route::post('/barang/tambah_simpan', [BarangController::class, 'tambah_simpan']);
// Route::get('/barang/ubah/{id}', [BarangController::class, 'ubah']);
// Route::put('/barang/ubah_simpan/{id}', [BarangController::class, 'ubah_simpan']);
// Route::get('/barang/hapus/{id}', [BarangController::class, 'hapus']);

// // Stok
// Route::get('/stok/tambah', [StokController::class, 'tambah']);
// Route::post('/stok/tambah_simpan', [StokController::class, 'tambah_simpan']);
// Route::get('/stok/ubah/{id}', [StokController::class, 'ubah']);
// Route::put('/stok/ubah_simpan/{id}', [StokController::class, 'ubah_simpan']);
// Route::get('/stok/hapus/{id}', [StokController::class, 'hapus']);

// // Penjualan
// Route::get('/penjualan/tambah', [PenjualanController::class, 'tambah']);
// Route::post('/penjualan/tambah_simpan', [PenjualanController::class, 'tambah_simpan']);
// Route::get('/penjualan/ubah/{id}', [PenjualanController::class, 'ubah']);
// Route::put('/penjualan/ubah_simpan/{id}', [PenjualanController::class, 'ubah_simpan']);
// Route::get('/penjualan/hapus/{id}', [PenjualanController::class, 'hapus']);

// // PenjualanDetail
// Route::get('/penjualan_detail/tambah', [PenjualanDetailController::class, 'tambah']);
// Route::post('/penjualan_detail/tambah_simpan', [PenjualanDetailController::class, 'tambah_simpan']);
// Route::get('/penjualan_detail/ubah/{id}', [PenjualanDetailController::class, 'ubah']);
// Route::put('/penjualan_detail/ubah_simpan/{id}', [PenjualanDetailController::class, 'ubah_simpan']);
// Route::get('/penjualan_detail/hapus/{id}', [PenjualanDetailController::class, 'hapus']);