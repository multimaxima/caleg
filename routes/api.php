<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // return $request->user();
// });

Route::controller(\App\Http\Controllers\Api\HomeController::class)->group(function () {
  Route::get('propinsi', 'propinsi');
  Route::get('kota', 'kota');
  Route::get('kecamatan', 'kecamatan');
  Route::get('desa', 'desa');
  Route::get('akses', 'akses');
  Route::get('beranda-info', 'beranda');
  //Route::get('keygen', 'keygen');
});

Route::controller(\App\Http\Controllers\Api\UserController::class)->group(function () {
  Route::get('get-user', 'getUser');
  Route::get('get-user-detil', 'getUserDetil');
  Route::get('get-nama', 'getNama');
  Route::get('get-akses', 'getAkses');
  Route::get('profil', 'profil');
  Route::post('profil', 'simpan');
  Route::get('hapus-akun', 'hapus');
});

Route::controller(\App\Http\Controllers\Api\PenggunaController::class)->group(function () {
  Route::get('pengguna', 'index');
  Route::post('pengguna', 'baru');
  Route::put('pengguna', 'edit');
  Route::delete('pengguna', 'hapus');
  Route::get('pengguna-detil', 'detil');
});

Route::controller(\App\Http\Controllers\Api\ResellerController::class)->group(function () {
  Route::get('reseller', 'index');
  Route::post('reseller', 'baru');
  Route::put('reseller', 'edit');
  Route::delete('reseller', 'hapus');
  Route::get('reseller-detil', 'detil');
});

Route::controller(\App\Http\Controllers\Api\CalegController::class)->group(function () {
  Route::get('caleg', 'index');
  Route::get('caleg-akses', 'akses');
  Route::post('caleg-baru', 'baru');
  Route::post('caleg-edit', 'edit');
  Route::delete('caleg', 'hapus');
  Route::get('caleg-detil', 'detil');
  Route::get('caleg-blokir', 'blokir');
  Route::get('caleg-buka-blokir', 'buka');
});

Route::controller(\App\Http\Controllers\Api\RelawanController::class)->group(function () {
  Route::get('relawan', 'index');
  Route::post('relawan-baru', 'baru');
  Route::post('relawan-edit', 'edit');
  Route::delete('relawan-hapus', 'hapus');
  Route::get('relawan-detil', 'detil');
});

Route::controller(\App\Http\Controllers\Api\PartaiController::class)->group(function () {
  Route::get('partai', 'index');
  Route::post('partai-baru', 'baru');
  Route::post('partai-edit', 'edit');
  Route::delete('partai', 'hapus');
  Route::get('partai-detil', 'detil');
});

Route::controller(\App\Http\Controllers\Api\InformasiController::class)->group(function () {
  Route::get('informasi', 'index');
});

Route::controller(\App\Http\Controllers\Api\DistributorController::class)->group(function () {
  Route::get('distributor', 'index');
});

Route::controller(\App\Http\Controllers\Api\TpsController::class)->group(function () {
  Route::get('tps', 'index');
  Route::get('tps-detil', 'detil');
  Route::post('tps-baru', 'baru');
  Route::post('tps-edit', 'edit');
});    

//ROUTE CALEG
Route::controller(\App\Http\Controllers\Api\Caleg\CalegController::class)->group(function () {
  Route::get('tim-akses', 'akses');
});

Route::controller(\App\Http\Controllers\Api\Caleg\RelawanController::class)->group(function () {
  Route::get('caleg-relawan', 'index');
  Route::post('caleg-relawan-baru', 'baru');
  Route::post('caleg-relawan-edit', 'edit');
  Route::delete('caleg-relawan-hapus', 'hapus');
  Route::get('caleg-relawan-detil', 'detil');

  Route::get('caleg-relawan-anggota', 'anggota');
  Route::get('caleg-relawan-daftar', 'daftar');
});

Route::controller(\App\Http\Controllers\Api\Caleg\ChatController::class)->group(function () {
  Route::get('chat', 'index');
});  


//ROUTE TIMSES
Route::controller(\App\Http\Controllers\Api\Relawan\RelawanController::class)->group(function () {
  Route::get('tim-relawan', 'index');
});