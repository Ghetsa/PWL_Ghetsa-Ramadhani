<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;


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
Route::get('/hello', [WelcomeController::class, 'hello']);

// Route::get('/', [PageController::class, 'index']);

// Route::get('/about', [PageController::class, 'about']);

// Route::get('/articles/{id}', [PageController::class, 'articles']);

Route::resource('photos', PhotoController::class);

Route::resource('photos', PhotoController::class)->only([
    'index',
    'show'
]);
Route::resource('photos', PhotoController::class)->except([
    'create',
    'store',
    'update',
    'destroy'
]);

// Route::get('/greeting', function () {
//     return view('blog.hello', ['name' => 'Andi']);
// });
Route::get('/greeting', [WelcomeController::class, 'greeting']);

Route::get('/home', HomeController::class);

Route::get('/about', AboutController::class);

Route::get('/article/{id}', ArticleController::class);

// Route::get('/hello', function () {
//     return 'Hello World';
// });


// Route::get('/world', function () {
//     return 'World';
// });

// Route::get('/about', function () {
//     return 'Ghetsa Ramadhani / 2341720004';
// });

// Route::get('/', function () {
//     return 'Selamat Datang';
// });

// Route::get('/user/{name}', function ($name) {
//     return 'Nama saya ' . $name;
// });

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Pos ke-' . $postId . " Komentar ke-" . $commentId;
});

// Route::get('/user/{name?}', function ($name = null) {
//     return 'Nama saya ' . $name;
// });

// Route::get('/user/{name?}', function ($name = 'Ghetsa') {
//     return 'Nama saya ' . $name;
// });

Route::get('/user/profile', function () {
    return 'Profile User';
})->name('profile');

Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile');
