<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;

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
Route::get('/products', function () {
    return view('products.index');
})->name('product');


// Route Home
Route::get('/', [HomeController::class, 'index']);

// Route Product menggunakan Prefix
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProductController::class, 'foodBeverage'])->name('category.food-beverage');
    Route::get('/beauty-health', [ProductController::class, 'beautyHealth'])->name('category.beauty-health');
    Route::get('/home-care', [ProductController::class, 'homeCare'])->name('category.home-care');
    Route::get('/baby-kid', [ProductController::class, 'babyKid'])->name('category.baby-kid');
});

// Route User menggunakan Parameter
Route::get('/user/{id}/name/{name}', [UserController::class, 'show'])->name('user.show');

// Route Penjualan (POS)
Route::get('/sales', [SalesController::class, 'index'])->name('sales');

Route::get('/transaksi', function () {
    return view('transactions.index');
});

Route::get('/transaksi', function () {
    $transaksi = Transaksi::all();
    return view('transactions.index', compact('transactions'));
});



// ---------------------------------------------------------------- 
// Jobsheet 3
// ----------------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);