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

Route::middleware('auth:api')->get('/pegawai', function (Request $request) {
    return $request->user();
});

// Login
Route::post('login', 'App\Http\Controllers\Api\LoginController@login');
Route::get('logout', 'App\Http\Controllers\Api\LoginController@logout');


Route::apiResource('/member', App\Http\Controllers\MemberController::class);
Route::apiResource('/aktivasi', App\Http\Controllers\AktivasiController::class);
Route::apiResource('/uang', App\Http\Controllers\DepositUangController::class);
Route::apiResource('/transaksi', App\Http\Controllers\TransaksiDepositKelasController::class);
Route::apiResource('/instruktur', App\Http\Controllers\InstrukturController::class);
Route::apiResource('/jadwal', App\Http\Controllers\JadwalUmumController::class);
Route::apiResource('/harian', App\Http\Controllers\JadwalHarianController::class);

Route::apiResource('/gym', App\Http\Controllers\BookingGymController::class);
Route::apiResource('/izin', App\Http\Controllers\IzinController::class);
Route::apiResource('/bookingKelas', App\Http\Controllers\BookingKelasController::class);
Route::apiResource('/kelas', App\Http\Controllers\KelasController::class);
Route::apiResource('/promo', App\Http\Controllers\PromoController::class);
Route::get('pegawai', 'App\Http\Controllers\Api\LoginController@showPegawai');




// Bagian Tombol 
Route::get('hapus/{id}', 'App\Http\Controllers\MemberController@hapus'); 
Route::get('reset/{id}', 'App\Http\Controllers\MemberController@resetPassword');
Route::post('generateJadwal', 'App\Http\Controllers\JadwalHarianController@generateJadwal');
Route::post('presensi/{no_struk_gym}', 'App\Http\Controllers\BookingGymController@presensi');


// Cetak 
Route::get('cetakMember/{id}', 'App\Http\Controllers\MemberController@cetakMember');
Route::get('cetakAktivasi/{no_struk_aktivasi}', 'App\Http\Controllers\AktivasiController@cetakAktivasi');
Route::get('cetakUang/{no_struk_uang}', 'App\Http\Controllers\DepositUangController@cetakDepositUang');
Route::get('cetakKelas/{no_struk_kelas}', 'App\Http\Controllers\TransaksiDepositKelasController@cetakDepositKelas');
Route::get('cetak/{no_struk_gym}', 'App\Http\Controllers\BookingGymController@cetak');
Route::get('cetakpaket/{no_struk_booking_kelas}', 'App\Http\Controllers\BookingKelasController@cetakPaket');
Route::get('cetakreguler/{no_struk_booking_kelas}', 'App\Http\Controllers\BookingKelasController@cetakReguler');