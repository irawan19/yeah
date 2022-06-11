<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController as DashboardController;
use App\Http\Controllers\Dashboard\KonfigurasiProfilController as DashboardKonfigurasiProfilController;
use App\Http\Controllers\Dashboard\KonfigurasiAkunController as DashboardKonfigurasiAkunController;

use App\Http\Controllers\Dashboard\MenuController as DashboardMenuController;
use App\Http\Controllers\Dashboard\LevelSistemController as DashboardLevelSistemController;
use App\Http\Controllers\Dashboard\AdminController as DashboardAdminController;
use App\Http\Controllers\Dashboard\KonfigurasiAplikasiController as DashboardKonfigurasiAplikasiController;

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
    return view('welcome');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:sanctum', config('jetstream.auth_session'), 'verified', 'cekuser']], function(){
    //Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/home', [DashboardController::class, 'index']);
        Route::get('/dashboard', [DashboardController::class, 'index']);

    //Konfigurasi Profil
        Route::group(['prefix' => 'konfigurasi_profil'], function(){
            Route::get('/', [DashboardKonfigurasiProfilController::class, 'index']);
            Route::post('/prosesedit', [DashboardKonfigurasiProfilController::class, 'prosesedit']);
        });

    //Konfigurasi Akun
        Route::group(['prefix' => 'konfigurasi_akun'], function() {
            Route::get('/', [DashboardKonfigurasiAkunController::class, 'index']);
            Route::post('/prosesedit', [DashboardKonfigurasiAkunController::class, 'prosesedit']);
        });
    
    //Konfigurasi Dashboard
        //Menu
            Route::group(['prefix' => 'menu'], function () {
                Route::get('/', [DashboardMenuController::class, 'index']);
                Route::get('/cari', [DashboardMenuController::class, 'cari']);
                Route::get('/urutan', [DashboardMenuController::class, 'urutan']);
                Route::post('/prosesurutan', [DashboardMenuController::class, 'prosesurutan']);
                Route::get('/tambah', [DashboardMenuController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardMenuController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardMenuController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardMenuController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardMenuController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardMenuController::class, 'hapus']);
                Route::get('/submenu/{id}', [DashboardMenuController::class, 'submenu']);
                Route::get('/cari_submenu/{id}', [DashboardMenuController::class, 'cari_submenu']);
                Route::get('/tambah_submenu/{id}', [DashboardMenuController::class, 'tambah_submenu']);
                Route::post('/prosestambah_submenu/{id}', [DashboardMenuController::class, 'prosestambah_submenu']);
                Route::get('/urutan_submenu/{id}', [DashboardMenuController::class, 'urutan_submenu']);
                Route::get('/baca_submenu/{id}', [DashboardMenuController::class, 'baca_submenu']);
                Route::get('/edit_submenu/{id}', [DashboardMenuController::class, 'edit_submenu']);
                Route::post('/prosesedit_submenu/{id}', [DashboardMenuController::class, 'prosesedit_submenu']);
                Route::get('/hapus_submenu/{id}', [DashboardMenuController::class, 'hapus_submenu']);
            });

        //Level Sistem
            Route::group(['prefix' => 'level_sistem'], function () {
                Route::get('/', [DashboardLevelSistemController::class, 'index']);
                Route::get('/cari', [DashboardLevelSistemController::class, 'cari']);
                Route::get('/tambah', [DashboardLevelSistemController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardLevelSistemController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardLevelSistemController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardLevelSistemController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardLevelSistemController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardLevelSistemController::class, 'hapus']);
            });

        //Admin
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/', [DashboardAdminController::class, 'index']);
                Route::get('/cari', [DashboardAdminController::class, 'cari']);
                Route::get('/tambah', [DashboardAdminController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardAdminController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardAdminController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardAdminController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardAdminController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardAdminController::class, 'hapus']);
            });

        //Konfigurasi Aplikasi
            Route::group(['prefix' => 'konfigurasi_aplikasi'], function () {
                Route::get('/', [DashboardKonfigurasiAplikasiController::class, 'index']);
                Route::post('/prosesedit', [DashboardKonfigurasiAplikasiController::class, 'prosesedit']);
                Route::post('/proseseditlogo', [DashboardKonfigurasiAplikasiController::class, 'proseseditlogo']);
                Route::post('/prosesediticon', [DashboardKonfigurasiAplikasiController::class, 'prosesediticon']);
                Route::post('/proseseditlogotext', [DashboardKonfigurasiAplikasiController::class, 'proseseditlogotext']);
            });

    //Logout
        Route::get('/logout', [DashboardController::class, 'logout']);
});
