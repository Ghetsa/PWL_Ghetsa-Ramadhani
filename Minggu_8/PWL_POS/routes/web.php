<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
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
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);


// Middleware untuk semua route harus login dulu
Route::middleware(['auth'])->group(function () {
    Route::get('/', [WelcomeController::class, 'index']);

    // 🔹 1. Administrator (ADM): Bisa CRUD semua data + AJAX CRUD
    Route::middleware(['authorize:ADM'])->group(function () {
        $resources = ['level', 'barang', 'kategori', 'stok', 'supplier', 'user'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            // 🔹 Standar CRUD
            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);
            Route::get("/$resource/{id}", [$controller, 'show']);
            Route::get("/$resource/{id}/edit", [$controller, 'edit']);
            Route::put("/$resource/{id}", [$controller, 'update']);
            Route::delete("/$resource/{id}", [$controller, 'destroy']);

            // 🔹 CRUD via AJAX
            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);

            Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // ajax import excel
        }
    });

    // 🔹 2. Manager (MNG): Bisa CRUD Barang, Kategori, Stok, Supplier via AJAX
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        $resources = ['barang', 'kategori', 'stok', 'supplier'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            // 🔹 Standar CRUD
            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);
            Route::get("/$resource/{id}", [$controller, 'show']);
            Route::delete("/$resource/{id}", [$controller, 'destroy']);

            // 🔹 CRUD via AJAX
            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);

            Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
            Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
            Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // ajax import excel
        }
    });

    // 🔹 3. Staff & Kasir (STF, KSR): Bisa CRUD Barang & Stok via AJAX
    Route::middleware(['authorize:ADM,MNG,STF,KSR'])->group(function () {
        $resources = ['barang', 'stok'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            // 🔹 Standar CRUD
            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/create", [$controller, 'create']);
            Route::post("/$resource", [$controller, 'store']);

            // 🔹 CRUD via AJAX
            Route::get("/$resource/create_ajax", [$controller, 'create_ajax']);
            Route::post("/$resource/ajax", [$controller, 'store_ajax']);
            Route::get("/$resource/{id}/edit_ajax", [$controller, 'edit_ajax']);
            Route::put("/$resource/{id}/update_ajax", [$controller, 'update_ajax']);
            Route::get("/$resource/{id}/delete_ajax", [$controller, 'confirm_ajax']);
            Route::delete("/$resource/{id}/delete_ajax", [$controller, 'delete_ajax']);

            Route::get('/$resource/import', [$controller, 'import']); // ajax form upload excel
            Route::post('/$resource/import_ajax', [$controller, 'import_ajax']); // ajax import excel
        }
    });

    // 🔹 4. Owner (OWN): Hanya bisa melihat data tanpa bisa CRUD
    Route::middleware(['authorize:ADM,MNG,STF,KSR,OWN'])->group(function () {
        $resources = ['level', 'barang', 'kategori', 'stok', 'supplier', 'user'];

        foreach ($resources as $resource) {
            $controller = "App\\Http\\Controllers\\" . ucfirst($resource) . "Controller";

            // 🔹 Hanya bisa melihat data
            Route::get("/$resource", [$controller, 'index']);
            Route::post("/$resource/list", [$controller, 'list']);
            Route::get("/$resource/{id}", [$controller, 'show']);
        }
    });
});

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
//     Route::get('/food-beverage', [BarangController::class, 'foodBeverage'])->name('category.food-beverage');
//     Route::get('/beauty-health', [BarangController::class, 'beautyHealth'])->name('category.beauty-health');
//     Route::get('/home-care', [BarangController::class, 'homeCare'])->name('category.home-care');
//     Route::get('/baby-kid', [BarangController::class, 'babyKid'])->name('category.baby-kid');
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


// // Praktikum 2
// Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
//     Route::get('/', [WelcomeController::class, 'index']);
//     // route Level

//     // artinya semua route di dalam group ini harus punya role ADM (Administrator)
//     Route::middleware(['authorize:ADM'])->group(function () {
//         Route::get('/level', [LevelController::class, 'index']);
//         Route::post('/level/list', [LevelController::class, 'list']); // untuk list json datatables
//         Route::get('/level/create', [LevelController::class, 'create']);
//         Route::post('/level/create', [LevelController::class, 'store']);
//         Route::get('/level/{id}/edit', [LevelController::class, 'edit']); // untuk tampilkan form edit
//         Route::post('/level/{id}', [LevelController::class, 'update']); // untuk proses update data
//         Route::delete('/level/{id}', [LevelController::class, 'destroy']); // untuk proses hapus data
//     });

//     // Praktikum 3
//     // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
//     Route::middleware(['authorize:ADM,MNG'])->group(function () {
//         Route::get('/barang', [BarangController::class, 'index']);
//         Route::post('/barang/list', [BarangController::class, 'list']);
//         Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
//         Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
//         Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
//         Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
//         Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm delete
//         Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
//     });

//     // Praktikum 3
//     // artinya semua route di dalam group ini harus punya role ADM (Administrator) dan MNG (Manager)
//     Route::middleware(['authorize:ADM,MNG,KSR,OWN'])->group(function () {
//         Route::get('/barang', [BarangController::class, 'index']);
//         Route::post('/barang/list', [BarangController::class, 'list']);
//         Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
//         Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
//         Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
//         Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
//         Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm delete
//         Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete
//     });






// masukkan semua route yang perlu autentikasi di sini
// ---------------------------------------------------------------- 
// Jobsheet 5
// ----------------------------------------------------------------
// Praktikum 2 - Langkah 5
// Route::get('/', [WelcomeController::class, 'index']);

// // Praktikum 3 - Langkah 3 &  JS6 - Praktikum 1 - Langkah 6
// Route::group(['prefix' => 'user'], function () {
//     Route::get('/', [UserController::class, 'index']); // Menampilkan halaman awal user
//     Route::post('/list', [UserController::class, 'list']); // Menampilkan data user dalam bentuk json untuk datatables
//     Route::get('/create', [UserController::class, 'create']); // Menampilkan halaman form tambah user
//     Route::post('/', [UserController::class, 'store']); // Menyimpan data user baru
//     Route::get('/create_ajax', [UserController::class, 'create_ajax']); // Menampilkan halaman form tambah user Ajax
//     Route::post('/ajax', [UserController::class, 'store_ajax']); // Menyimpan data user baru Ajax
//     Route::get('/{id}', [UserController::class, 'show']); // Menampilkan detail user
//     Route::get('/{id}/edit', [UserController::class, 'edit']); // Menampilkan halaman form edit user
//     Route::put('/{id}', [UserController::class, 'update']); // Menyimpan perubahan data user
//     Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // Menampilkan halaman form edit user Ajax
//     Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // Menyimpan perubahan data user Ajax
//     Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete user Ajax
//     Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // Untuk hapus data user Ajax
//     Route::delete('/{id}', [UserController::class, 'destroy']); // Menghapus data user
// });

// -------------------------------
// TUGAS 
// -------------------------------
// Route::group(['prefix' => 'level'], function () {
//     Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal Level
//     Route::post('/list', [LevelController::class, 'list']); // menampilkan data Level dalam bentuk json untuk datatables
//     Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah Level
//     Route::post('/', [LevelController::class, 'store']); // menyimpan data Level baru
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // Menampilkan halaman form tambah Level Ajax
//     Route::post('/ajax', [LevelController::class, 'store_ajax']); // Menyimpan data Level baru Ajax
//     Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data Level
//     Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail Level
//     Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit Level
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // Menampilkan halaman form edit Level Ajax
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // Menyimpan perubahan data Level Ajax
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Level Ajax
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // Untuk hapus data Level Ajax
//     Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data Level
// });
// -------------------------------
// Route::group(['prefix' => 'kategori'], function () {
//     Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal Kategori
//     Route::post('/list', [KategoriController::class, 'list']); // menampilkan data Kategori dalam bentuk json untuk datatables
//     Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah Kategori
//     Route::post('/', [KategoriController::class, 'store']); // menyimpan data Kategori baru
//     Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // Menampilkan halaman form tambah Kategori Ajax
//     Route::post('/ajax', [KategoriController::class, 'store_ajax']); // Menyimpan data Kategori baru Ajax
//     Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail Kategori
//     Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit Kategori
//     Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data Kategori
//     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // Menampilkan halaman form edit Kategori Ajax
//     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // Menyimpan perubahan data Kategori Ajax
//     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Kategori Ajax
//     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // Untuk hapus data Kategori Ajax
//     Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data Kategori
// });
// // -------------------------------
// Route::group(['prefix' => 'stok'], function () {
//     Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal Stok
//     Route::post('/list', [StokController::class, 'list']); // menampilkan data Stok dalam bentuk json untuk datatables
//     Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah Stok
//     Route::post('/', [StokController::class, 'store']); // menyimpan data Stok baru
//     Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Menampilkan halaman form tambah Stok Ajax
//     Route::post('/ajax', [StokController::class, 'store_ajax']); // Menyimpan data Stok baru Ajax
//     Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail Stok
//     Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit Stok
//     Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data Stok
//     Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // Menampilkan halaman form edit Stok Ajax
//     Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']); // Menyimpan perubahan data Stok Ajax
//     Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Stok Ajax
//     Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // Untuk hapus data Stok Ajax
//     Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data Stok
// });
// // -------------------------------
// Route::group(['prefix' => 'supplier'], function () {
//     Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal Supplier
//     Route::post('/list', [SupplierController::class, 'list']); // menampilkan data Supplier dalam bentuk json untuk datatables
//     Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah Supplier
//     Route::post('/', [SupplierController::class, 'store']); // menyimpan data Supplier baru
//     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // Menampilkan halaman form tambah Supplier Ajax
//     Route::post('/ajax', [SupplierController::class, 'store_ajax']); // Menyimpan data Supplier baru Ajax
//     Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail Supplier
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit Supplier
//     Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data Supplier
//     Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // Menampilkan halaman form edit Supplier Ajax
//     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // Menyimpan perubahan data Supplier Ajax
//     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Supplier Ajax
//     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // Untuk hapus data Supplier Ajax
//     Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data Supplier
// });
// -------------------------------
// Route::group(['prefix' => 'barang'], function () {
//     Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal Product
//     Route::post('/list', [BarangController::class, 'list']); // menampilkan data Product dalam bentuk json untuk datatables
//     Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah Product
//     Route::post('/', [BarangController::class, 'store']); // menyimpan data Product baru
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // Menampilkan halaman form tambah Product Ajax
//     Route::post('/ajax', [BarangController::class, 'store_ajax']); // Menyimpan data Product baru Ajax
//     Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail Product
//     Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit Product
//     Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data Product
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // Menampilkan halaman form edit Product Ajax
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // Menyimpan perubahan data Product Ajax
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilkan form confirm delete Product Ajax
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // Untuk hapus data Product Ajax
//     Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data Product
// });
// });