<?php

use Illuminate\Support\Facades\Route;
use App\Models\Master_konfigurasi_aplikasi;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

//Dashboard
use App\Http\Controllers\Dashboard\DashboardController as DashboardController;
use App\Http\Controllers\Dashboard\KonfigurasiProfilController as DashboardKonfigurasiProfilController;
use App\Http\Controllers\Dashboard\KonfigurasiAkunController as DashboardKonfigurasiAkunController;

//Event
use App\Http\Controllers\Dashboard\EventController as DashboardEventController;
use App\Http\Controllers\Dashboard\TicketController as DashboardTicketController;
use App\Http\Controllers\Dashboard\PromoController as DashboardPromoController;
use App\Http\Controllers\Dashboard\RegistrasiEventController as DashboardRegistrasiEventController;

//Baca
use App\Http\Controllers\Dashboard\PembayaranController as DashboardPembayaranController;

//Sosial Media
use App\Http\Controllers\Dashboard\MetaTagController as DashboardMetaTagController;
use App\Http\Controllers\Dashboard\SosialMediaController as DashboardSosialMediaController;

//Konfigurasi Aplikasi
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

Route::get('/sitemap', function(){
	$konfigurasiaplikasi = Master_konfigurasi_aplikasi::first();
	$sitemap = Sitemap::create()
						->add(url::create('/')->addImage(url('/'.$konfigurasiaplikasi->logo_konfigurasi_aplikasis), $konfigurasiaplikasi->nama_konfigurasi_aplikasis));
	$sitemap->writeToFile(public_path('sitemap.xml'));
	return redirect('public/sitemap.xml');
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

    //Event
        //Event
            Route::group(['prefix' => 'event'], function() {
                Route::get('/', [DashboardEventController::class, 'index']);
                Route::get('/cari', [DashboardEventController::class, 'cari']);
                Route::get('/tambah', [DashboardEventController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardEventController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardEventController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardEventController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardEventController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardEventController::class, 'hapus']);
            });
        
        //Ticket
            Route::group(['prefix' => 'ticket'], function() {
                Route::get('/', [DashboardTicketController::class, 'index']);
                Route::get('/cari', [DashboardTicketController::class, 'cari']);
                Route::get('/tambah', [DashboardTicketController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardTicketController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardTicketController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardTicketController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardTicketController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardTicketController::class, 'hapus']);
            });
        
        //Promo
            Route::group(['prefix' => 'promo'], function() {
                Route::get('/', [DashboardPromoController::class, 'index']);
                Route::get('/cari', [DashboardPromoController::class, 'cari']);
                Route::get('/tambah', [DashboardPromoController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardPromoController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardPromoController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardPromoController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardPromoController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardPromoController::class, 'hapus']);
            });

        //Registrasi Event
            Route::group(['prefix' => 'registrasi_event'], function() {
                Route::get('/', [DashboardRegistrasiEventController::class, 'index']);
                Route::get('/cari', [DashboardRegistrasiEventController::class, 'cari']);
                Route::get('/tambah', [DashboardRegistrasiEventController::class, 'tambah']);
                Route::post('/prosestambah', [DashboardRegistrasiEventController::class, 'prosestambah']);
                Route::get('/baca/{id}', [DashboardRegistrasiEventController::class, 'baca']);
                Route::get('/edit/{id}', [DashboardRegistrasiEventController::class, 'edit']);
                Route::post('/prosesedit/{id}', [DashboardRegistrasiEventController::class, 'prosesedit']);
                Route::get('/hapus/{id}', [DashboardRegistrasiEventController::class, 'hapus']);
                Route::get('/cetakexcel', [DashboardRegistrasiEventController::class, 'cetakexcel']);
            });
    
    //Pembayaran
        Route::group(['prefix' => 'pembayaran'], function() {
            Route::get('/', [DashboardPembayaranController::class, 'index']);
            Route::get('/cari', [DashboardPembayaranController::class, 'cari']);
            Route::get('/tambah', [DashboardPembayaranController::class, 'tambah']);
            Route::post('/prosestambah', [DashboardPembayaranController::class, 'prosestambah']);
            Route::get('/baca/{id}', [DashboardPembayaranController::class, 'baca']);
            Route::get('/edit/{id}', [DashboardPembayaranController::class, 'edit']);
            Route::post('/prosesedit/{id}', [DashboardPembayaranController::class, 'prosesedit']);
            Route::get('/hapus/{id}', [DashboardPembayaranController::class, 'hapus']);
        });
    
    //Sosial Media
        //Meta Tag
            Route::group(['prefix' => 'meta_tag'], function() {
                Route::get('/', [DashboardMetaTagController::class, 'index']);
                Route::post('/prosesedit/{id}', [DashboardMetaTagController::class, 'prosesedit']);
            });

        //Sosial Media
			Route::group(['prefix' => 'sosial_media'], function() {
				Route::get('/', [DashboardSosialMediaController::class, 'index']);
				Route::get('/cari', [DashboardSosialMediaController::class, 'cari']);
				Route::get('/tambah', [DashboardSosialMediaController::class, 'tambah']);
				Route::post('/prosestambah', [DashboardSosialMediaController::class, 'prosestambah']);
				Route::get('/edit/{id}', [DashboardSosialMediaController::class, 'edit']);
				Route::post('/prosesedit/{id}', [DashboardSosialMediaController::class, 'prosesedit']);
				Route::get('/hapus/{id}', [DashboardSosialMediaController::class, 'hapus']);
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
