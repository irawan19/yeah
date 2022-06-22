<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DataController;
use App\Http\Controllers\Api\V1\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function(){
    Route::group(['prefix' => 'data'], function(){
        Route::get('/jeniskelamin', [DataController::class, 'jeniskelamin']);
        Route::get('/pembayaran', [DataController::class, 'pembayaran']);
        Route::get('/statuspembayaran', [DataController::class, 'statuspembayaran']);
        Route::get('/konfigurasiaplikasi', [DataController::class, 'konfigurasiaplikasi']);
    });

    Route::group(['prefix' => 'event'], function() {
        Route::get('/', [EventController::class, 'event']);
        Route::get('/{id}', [EventController::class, 'eventdetail']);
        Route::post('/registrasi', [EventController::class, 'registrasi']);
        Route::post('/cekticket', [EventController::class, 'cekticket']);
    });
});