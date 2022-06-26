<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\PaketController;
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

Route::get('/', function () {
    // return view('welcome');
    
    return redirect(route('login'));
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login-process');
Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

Route::prefix('backend')->middleware('auth')->name('backend.')->group(function () {
    Route::get('/', [BackendController::class, 'main'])->name('main');

    Route::resource('user', UserController::class);
    Route::resource('paket', PaketController::class);
});
