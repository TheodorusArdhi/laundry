<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/',[UserController::class,'home']);
    
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/postLogin',[AuthController::class,'postLogin'])->name('postLogin');
    Route::get('/register',[AuthController::class,'register']);
    Route::post('/postRegister',[AuthController::class,'postRegister'])->name('postRegister');
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout'); 

Route::middleware(['auth', 'checkLevel:admin'])->group(function () {

    Route::get('/layanan',[AdminController::class,'layanan']);
    Route::get('/tambahLayanan',[AdminController::class,'tambahLayanan']);
    Route::post('/postLayanan',[AdminController::class,'postLayanan'])->name('postLayanan');
    Route::get('/editLayanan/{id}',[AdminController::class,'editLayanan']);
    Route::post('/updateLayanan/{id}',[AdminController::class,'updateLayanan'])->name('updateLayanan');
    Route::delete('/hapusLayanan/{id}',[AdminController::class,'hapusLayanan'])->name('hapusLayanan');

    Route::get('/pengumuman',[AdminController::class,'pengumuman']);
    Route::get('/tambahPengumuman',[AdminController::class,'tambahPengumuman']);
    Route::post('/postPengumuman',[AdminController::class,'postPengumuman'])->name('postPengumuman');
    Route::get('/editPengumuman/{id}',[AdminController::class,'editPengumuman']);
    Route::post('/updatePengumuman/{id}',[AdminController::class,'updatePengumuman'])->name('updatePengumuman');
    Route::delete('/hapusPengumuman/{id}',[AdminController::class,'hapusPengumuman'])->name('hapusPengumuman');

    Route::get('/pengguna',[AdminController::class,'pengguna']);
    Route::get('/tambahPengguna',[AdminController::class,'tambahPengguna']);
    Route::post('/postPengguna',[AdminController::class,'postPengguna'])->name('postPengguna');
    Route::delete('/hapusPengguna/{id}',[AdminController::class,'hapusPengguna'])->name('hapusPengguna');

    Route::get('/transaksiAdmin',[AdminController::class,'transaksiAdmin']);
    Route::get('/lihatTransaksi/{id}',[AdminController::class,'lihatTransaksi']);
    Route::get('/tambahTransaksi',[AdminController::class,'tambahTransaksi']);
    Route::get('/transaksiDetail',[AdminController::class,'transaksiDetail']);
    Route::get('/transaksiLunas/{id}',[AdminController::class,'transaksiLunas']);
    Route::get('/transaksiDiambil/{id}',[AdminController::class,'transaksiDiambil']);
    Route::post('/tambahTransaksiDetail',[AdminController::class,'tambahTransaksiDetail'])->name('tambahTransaksiDetail');
    Route::post('/updateTransaksiDetail/{id}',[AdminController::class,'updateTransaksiDetail'])->name('updateTransaksiDetail');
    Route::post('/diskon',[AdminController::class,'diskon'])->name('diskon');
    Route::post('/simpanTransaksi',[AdminController::class,'simpanTransaksi'])->name('simpanTransaksi');
    Route::delete('/hapusTransaksiDetail/{id}',[AdminController::class,'hapusTransaksiDetail'])->name('hapusTransaksiDetail');
    
}); 

Route::middleware(['auth', 'checkLevel:pengguna'])->group(function () {
    
    Route::get('/transaksiPengguna',[UserController::class,'transaksiPengguna']);
    Route::get('/lihatTransaksiPengguna/{id}',[UserController::class,'lihatTransaksiPengguna']);

}); 

Route::middleware(['auth', 'checkLevel:pengguna,admin'])->group(function () {

    Route::get('/dashboard',[UserController::class,'dashboard']);
    Route::get('/password',[AuthController::class,'password']);
    Route::post('/postPassword',[AuthController::class,'postPassword'])->name('postPassword');
    Route::get('/profile',[UserController::class,'profile']);
    Route::post('/editProfile',[UserController::class,'editProfile'])->name('editProfile');
    Route::get('/transaksiNota/{id}',[UserController::class,'transaksiNota']);
    Route::get('/transaksiUnduh/{id}/unduh',[UserController::class,'transaksiUnduh']);

}); 