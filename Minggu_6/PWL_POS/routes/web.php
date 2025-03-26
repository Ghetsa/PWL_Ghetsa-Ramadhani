<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
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
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/products', function () {
//     return view('products.index');
// })->name('product');


// // Route Home
// // Route::get('/', [HomeController::class, 'index']);

// // Route Product menggunakan Prefix
// Route::prefix('category')->group(function () {
//     Route::get('/food-beverage', [ProductController::class, 'foodBeverage'])->name('category.food-beverage');
//     Route::get('/beauty-health', [ProductController::class, 'beautyHealth'])->name('category.beauty-health');
//     Route::get('/home-care', [ProductController::class, 'homeCare'])->name('category.home-care');
//     Route::get('/baby-kid', [ProductController::class, 'babyKid'])->name('category.baby-kid');
// });

// // Route User menggunakan Parameter
// Route::get('/user/{id}/name/{name}', [UserController::class, 'show'])->name('user.show');

// // Route Penjualan (POS)
// Route::get('/sales', [SalesController::class, 'index'])->name('sales');

// Route::get('/transaksi', function () {
//     return view('transactions.index');
// });

// Route::get('/transaksi', function () {
//     $transaksi = Transaksi::all();
//     return view('transactions.index', compact('transactions'));
// });



// // ---------------------------------------------------------------- 
// // Jobsheet 3
// // ----------------------------------------------------------------

// // Route::get('/', function () {
// //     return view('welcome');
// // });

// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);

// // ---------------------------------------------------------------- 
// // Jobsheet 4
// // ----------------------------------------------------------------
// // Praktikum 2.6 - Langkah 5
// Route::get('/user/tambah', [UserController::class, 'tambah']);

// // Praktikum 2.6 - Langkah 8
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// // Praktikum 2.6 - Langkah 12
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

// // Praktikum 2.6 - Langkah 15
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// // Praktikum 2.6 - Langkah 18
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// ---------------------------------------------------------------- 
// Jobsheet 5
// ----------------------------------------------------------------
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
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
    Route::delete('/{id}', [UserController::class, 'destroy']); // Menghapus data user
});



// -------------------------------
// TUGAS 
// -------------------------------
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal Level
    Route::post('/list', [LevelController::class, 'list']); // menampilkan data Level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah Level
    Route::post('/', [LevelController::class, 'store']); // menyimpan data Level baru
    Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit Level
    Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data Level
    Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data Level
});
// -------------------------------
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
    Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah Kategori
    Route::post('/', [KategoriController::class, 'store']); // menyimpan data Kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
    Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data Kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
});
// -------------------------------
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal Stok
    Route::post('/list', [StokController::class, 'list']); // menampilkan data Stok dalam bentuk json untuk datatables
    Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah Stok
    Route::post('/', [StokController::class, 'store']); // menyimpan data Stok baru
    Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail Stok
    Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit Stok
    Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data Stok
    Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data Stok
});
// -------------------------------
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
    Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
    Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
    Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
});
// -------------------------------
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [ProductController::class, 'index']); // menampilkan halaman awal Product
    Route::post('/list', [ProductController::class, 'list']); // menampilkan data Product dalam bentuk json untuk datatables
    Route::get('/create', [ProductController::class, 'create']); // menampilkan halaman form tambah Product
    Route::post('/', [ProductController::class, 'store']); // menyimpan data Product baru
    Route::get('/{id}', [ProductController::class, 'show']); // menampilkan detail Product
    Route::get('/{id}/edit', [ProductController::class, 'edit']); // menampilkan halaman form edit Product
    Route::put('/{id}', [ProductController::class, 'update']); // menyimpan perubahan data Product
    Route::delete('/{id}', [ProductController::class, 'destroy']); // menghapus data Product
});