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
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

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
// ------------------------------------
// Jobsheet 7
// ------------------------------------
// Praktikum 1
Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    // 1. Administrator (ADM): Bisa CRUD semua
    Route::middleware(['authorize:ADM'])->group(function () {
        $resources = ['level', 'user'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);
            Route::get("/$resource/{id}", [$controller, 'show']);
            Route::get("/$resource/{id}/edit", [$controller, 'edit']);
            Route::put("/$resource/{id}", [$controller, 'update']);
            Route::delete("/$resource/{id}", [$controller, 'destroy']);

            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);
            Route::get("/$resource/{id}/show_ajax", [$controller, 'show_ajax']);

            Route::get("/$resource/import", [$controller, 'import']);
            Route::post("/$resource/import_ajax", [$controller, 'import_ajax']);
            Route::get("/$resource/export_excel", [$controller, 'export_excel']);
            Route::get("/$resource/export_pdf", [$controller, 'export_pdf']);
        }
    });

    // 2. Manager (ADM, MNG): CRUD tanpa level & user
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        $resources = ['kategori', 'supplier'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);
            Route::get("/$resource/{id}", [$controller, 'show']);
            Route::delete("/$resource/{id}", [$controller, 'destroy']);

            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);
            Route::get("/$resource/{id}/show_ajax", [$controller, 'show_ajax']);

            Route::get("/$resource/import", [$controller, 'import']);
            Route::post("/$resource/import_ajax", [$controller, 'import_ajax']);
            Route::get("/$resource/export_excel", [$controller, 'export_excel']);
            Route::get("/$resource/export_pdf", [$controller, 'export_pdf']);
        }
    });

    // 3. Staff & Kasir (STF, KSR): CRUD via AJAX, TIDAK BISA akses level/user
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function () {
        Route::get('/penjualan/{id}/cetak_struk', [PenjualanController::class, 'cetak_struk'])->name('penjualan.cetak_struk');
        $resources = ['barang', 'stok', 'penjualan']; 

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);

            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);
            Route::get("/$resource/{id}/show_ajax", [$controller, 'show_ajax']);

            Route::get("/$resource/import", [$controller, 'import']);
            Route::post("/$resource/import_ajax", [$controller, 'import_ajax']);
            Route::get("/$resource/export_excel", [$controller, 'export_excel']);
            Route::get("/$resource/export_pdf", [$controller, 'export_pdf']);
        }
    });
});


// // Praktikum 2 - Langkah 5
// Route::get('/', [WelcomeController::class, 'index']);

// // -------------------------------
// // USER 
// // -------------------------------
// Route::group(['prefix' => 'user'], function () {
//     Route::get('/', [UserController::class, 'index']); // Menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']); // Menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']); // Menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']); // Menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
//     Route::get('/{id}', [UserController::class, 'show']); // Menampilkan detail user
//     Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [UserController::class, 'edit']); // Menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']); // Menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
//     Route::delete('/{id}', [UserController::class, 'destroy']); // Menghapus data user
// });
// // -------------------------------
// // LEVEL 
// // -------------------------------
// Route::group(['prefix' => 'level'], function () {
//     Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal Level
//     Route::post('/list', [LevelController::class, 'list']); // menampilkan data Level dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah Level
//     Route::post('/', [LevelController::class, 'store']); // menyimpan data Level baru
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah Level Ajax
//     Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data Level baru Ajax
//     Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data Level
//     Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail Level
//     Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit Level
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit Level Ajax
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data Level Ajax
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Level Ajax
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data Level Ajax
//     Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data Level
// });

// // -------------------------------
// // KATEGORI 
// // -------------------------------
// Route::group(['prefix' => 'kategori'], function () {
//     Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
//     Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
//     Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah Kategori
//     Route::post('/', [KategoriController::class, 'store']); // menyimpan data Kategori baru
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah Kategori Ajax
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data Kategori baru Ajax
//     Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori
//     Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
//     Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data Kategori
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit Kategori Ajax
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data Kategori Ajax
//     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Kategori Ajax
//     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data Kategori Ajax
//     Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
// });

// // -------------------------------
// // STOK 
// // -------------------------------
// Route::group(['prefix' => 'stok'], function () {
//     Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal Stok
//     Route::post('/list', [StokController::class, 'list']); // menampilkan data Stok dalam bentuk json untuk datatables
//     Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah Stok
//     Route::post('/', [StokController::class, 'store']); // menyimpan data Stok baru
//     Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Menampilkan halaman form tambah Stok Ajax
//     Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail Stok
//     Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit Stok
//     Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data Stok
//     Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // Menampilkan halaman form edit Stok Ajax
//     Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // Menyimpan perubahan data Stok Ajax
//     Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Stok Ajax
//     Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Untuk hapus data Stok Ajax
//     Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data Stok
// });

// // -------------------------------
// // SUPPLIER 
// // -------------------------------
// Route::group(['prefix' => 'supplier'], function () {
//     Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
//     Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
//     Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
//     Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
//     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
//     Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
//     Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
//     Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
//     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit Supplier Ajax
//     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data Supplier Ajax
//     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Supplier Ajax
//     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
//     Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
// });

// // -------------------------------
// // BARANG 
// // -------------------------------
// Route::group(['prefix' => 'barang'], function () {
//     Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Barang
//     Route::post('/list', [BarangController::class, 'list']); // menampilkan data Barang dalam bentuk json untuk datatables
//     Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah Barang
//     Route::post('/', [BarangController::class, 'store']); // menyimpan data Barang baru
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah Barang Ajax
//     Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Barang
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // Menampilkan halaman form tambah Stok Ajax
//     Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Barang
//     Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data Barang
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit Barang Ajax
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data Barang Ajax
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Barang Ajax
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data Barang Ajax
//     Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data Barang
// });

// // -------------------------------
// // PENJUALAN 
// // -------------------------------
// Route::group(['prefix' => 'penjualan'], function () {
//     Route::get('/', [PenjualanController::class, 'index']); // menampilkan halaman awal Penjualan
//     Route::post('/list', [PenjualanController::class, 'list']); // menampilkan data Penjualan dalam bentuk json untuk datatables
//     Route::get('/create', [PenjualanController::class, 'create']); // menampilkan halaman form tambah Penjualan
//     Route::post('/', [PenjualanController::class, 'store']); // menyimpan data Penjualan baru
//     Route::get('/create_ajax', [PenjualanController::class, 'create_ajax']); // Menampilkan halaman form tambah Penjualan Ajax
//     Route::post('/ajax', [PenjualanController::class, 'store_ajax']); // Menyimpan data Penjualan baru Ajax
//     Route::get('/{id}', [PenjualanController::class, 'show']); // menampilkan detail Penjualan
//     Route::get('/{id}/show_ajax', [PenjualanController::class, 'show_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::get('/{id}/edit', [PenjualanController::class, 'edit']); // menampilkan halaman form edit Penjualan
//     Route::put('/{id}', [PenjualanController::class, 'update']); // menyimpan perubahan data Penjualan
//     Route::get('/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']); // Menampilkan halaman form edit Penjualan Ajax
//     Route::put('/{id}/update_ajax', [PenjualanController::class, 'update_ajax']); // Menyimpan perubahan data Penjualan Ajax
//     Route::get('/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Penjualan Ajax
//     Route::delete('/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']); // Untuk hapus data Penjualan Ajax
//     Route::delete('/{id}', [PenjualanController::class, 'destroy']); // menghapus data Penjualan
// });


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