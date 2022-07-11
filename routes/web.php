<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PembelianPropertiController;
use App\Http\Controllers\PropertiController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'frontEnd'])->name('frontend');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login-process');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::prefix('backend')->middleware('auth')->name('backend.')->group(function () {
    Route::get('/', [BackendController::class, 'main'])->name('main');

    Route::resource('user', UserController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('studio', StudioController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('properti', PropertiController::class);

    Route::prefix('pembelian-properti')->name('pembelian.')->group(function() {
        Route::get('/', [PembelianPropertiController::class, 'index'])->name('index');
        Route::get('/create', [PembelianPropertiController::class, 'create'])->name('create');
        Route::post('/', [PembelianPropertiController::class, 'store'])->name('store');
        Route::get('/{pembelian}/edit', [PembelianPropertiController::class, 'edit'])->name('edit');
        Route::put('/{pembelian}/update', [PembelianPropertiController::class, 'update'])->name('update');
        Route::delete('/{pembelian}/destroy', [PembelianPropertiController::class, 'destroy'])->name('destroy');
    });
});
