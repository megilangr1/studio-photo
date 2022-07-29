<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PembelianPropertiController;
use App\Http\Controllers\PencatatanKasController;
use App\Http\Controllers\PrintController;
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

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registration'])->name('registration');

Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/booking', [MainController::class, 'booking'])->name('booking');
    Route::put('/booking/{id}/cancel', [MainController::class, 'cancelBooking'])->name('booking-cancel');
    Route::post('/upload-pembayaran', [MainController::class, 'uploadPembayaran'])->name('upload-pembayaran');

    Route::get('/data-booking', [MainController::class, 'dataBooking'])->name('data-booking');
    Route::get('/hasil-foto/{booking}', [MainController::class, 'hasilBooking'])->name('hasil-foto');
});


Route::prefix('backend')->middleware(['auth', 'role:Owner', 'role:Administrator'])->name('backend.')->group(function () {
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

    Route::resource('booking', BookingController::class);
    Route::put('booking/{booking}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
    Route::put('booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::post('booking/{booking}/uploadFoto', [BookingController::class, 'uploadFoto'])->name('booking.uploadFoto');

    Route::prefix('buku-kas')->name('kas.')->group(function() {
        Route::get('/', [PencatatanKasController::class, 'index'])->name('index');
        Route::get('/create', [PencatatanKasController::class, 'create'])->name('create');
        Route::post('/', [PencatatanKasController::class, 'store'])->name('store');
        Route::get('/{pembelian}/edit', [PencatatanKasController::class, 'edit'])->name('edit');
        Route::put('/{pembelian}/update', [PencatatanKasController::class, 'update'])->name('update');
        Route::delete('/{pembelian}/destroy', [PencatatanKasController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('print-data')->name('print-data.')->group(function() {
        Route::post('/print-transaksi-booking', [PrintController::class, 'dataBooking'])->name('data-booking');
    });

});
