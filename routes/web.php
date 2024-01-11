<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\PenyimpananController;
use App\Http\Controllers\LaporanController;

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
    Route::get('/',[HomeController::class,'home']);
    
    Route::get('/login/index',[AuthController::class,'indexLogin'])->name('indexLogin');
    Route::post('/login',[AuthController::class,'login'])->name('login');
    Route::get('/register/index',[AuthController::class,'indexRegister']);
    Route::post('/register/store',[AuthController::class,'storeRegister'])->name('storeRegister');
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout'); 

Route::prefix('/owner')->middleware(['auth', 'checkLevel:owner'])->group(function () {

    Route::get('/layanan',[LayananController::class,'index']);
    Route::get('/layanan/create',[LayananController::class,'create']);
    Route::post('/layanan/store',[LayananController::class,'store'])->name('store');
    Route::get('/layanan/{id}/edit',[LayananController::class,'edit']);
    Route::post('/layanan/{id}/update',[LayananController::class,'update'])->name('update');
    Route::delete('/layanan/{id}/delete',[LayananController::class,'delete'])->name('delete');

    Route::get('/cabang',[CabangController::class,'index']);
    Route::get('/cabang/create',[CabangController::class,'create']);
    Route::post('/cabang/store',[CabangController::class,'store'])->name('store');
    Route::get('/cabang/{id}/edit',[CabangController::class,'edit']);
    Route::post('/cabang/{id}/update',[CabangController::class,'update'])->name('update');
    Route::delete('/cabang/{id}/delete',[CabangController::class,'delete'])->name('delete');

    Route::get('/pengumuman',[PengumumanController::class,'index']);
    Route::get('/pengumuman/index/siaran',[PengumumanController::class,'indexSiaran']);
    Route::get('/pengumuman/create',[PengumumanController::class,'create']);
    Route::post('/pengumuman/store',[PengumumanController::class,'store'])->name('store');
    Route::post('/pengumuman/siaran',[PengumumanController::class,'siaran'])->name('siaran');
    Route::get('/pengumuman/{id}/edit',[PengumumanController::class,'edit']);
    Route::post('/pengumuman/{id}/update',[PengumumanController::class,'update'])->name('update');
    Route::delete('/pengumuman/{id}/delete',[PengumumanController::class,'delete'])->name('delete');

    Route::get('/user',[UserController::class,'index']);
    Route::get('/user/create',[UserController::class,'create']);

    Route::post('/penyimpanan/cabang',[PenyimpananController::class,'cabang']);

    Route::get('/laporan/penjualan',[LaporanController::class,'penjualan']);
    Route::post('/laporan/penjualan/tanggal',[LaporanController::class,'tanggalPenjualan']);
    Route::get('/laporan/layanan',[LaporanController::class,'layanan']);
    Route::post('/laporan/layanan/tanggal',[LaporanController::class,'tanggalLayanan']);
    Route::get('/penjualan/export/{awal}/{akhir}',[LaporanController::class, 'penjualanExport']);
    Route::get('/layanan/export/{awal}/{akhir}',[LaporanController::class, 'layananExport']);
}); 

Route::prefix('/admin')->middleware(['auth', 'checkLevel:admin'])->group(function () {

    Route::get('/transaksi/data',[TransaksiController::class,'data']);
    Route::get('/transaksi/create',[TransaksiController::class,'create']);
    Route::post('/transaksi/store',[TransaksiController::class,'store'])->name('store');
    Route::get('/transaksi/{id}/edit',[TransaksiController::class,'editAdmin'])->name('editAdmin');
    Route::post('/transaksi/{id}/update',[TransaksiController::class,'update'])->name('update');
    Route::post('/transaksi/diskon',[TransaksiController::class,'diskon'])->name('diskon');
    Route::post('/transaksi/poin',[TransaksiController::class,'poin'])->name('poin');
    Route::post('/transaksi/{id}/edit/poin',[TransaksiController::class,'poinEdit'])->name('poinEdit');
    Route::post('/transaksi/{id}/edit/diskon',[TransaksiController::class,'diskonEdit'])->name('diskonEdit');
    Route::get('/transaksi/{id}/batal',[TransaksiController::class,'batal'])->name('batal');
    Route::get('/transaksi/{id}/lunas',[TransaksiController::class,'lunas']);
    Route::get('/transaksi/{id}/ambil',[TransaksiController::class,'ambil']);

    Route::post('/transaksi/detail/store',[TransaksiDetailController::class,'store'])->name('store');
    Route::post('/transaksi/detail/{id}/update',[TransaksiDetailController::class,'update'])->name('update');
    Route::delete('/transaksi/detail/{id}/delete',[TransaksiDetailController::class,'delete'])->name('delete');
    Route::post('/transaksi/detail/{id}/edit/store',[TransaksiDetailController::class,'storeEdit'])->name('storeEdit');
    Route::post('/transaksi/detail/{id}/edit/update',[TransaksiDetailController::class,'updateEdit'])->name('updateEdit');
    Route::delete('/transaksi/detail/{id}/edit/delete',[TransaksiDetailController::class,'deleteEdit'])->name('deleteEdit');
}); 

Route::prefix('/admin')->middleware(['auth', 'checkLevel:admin,owner'])->group(function () {

    Route::get('/user',[UserController::class,'indexAdmin']);
    Route::post('/user/store',[UserController::class,'store'])->name('store');
    Route::get('/user/{id}/edit',[UserController::class,'edit']);
    Route::post('/user/{id}/update',[UserController::class,'update'])->name('update');
    Route::delete('/user/{id}/delete',[UserController::class,'delete'])->name('delete');

    Route::get('/transaksi',[TransaksiController::class,'indexAdmin']);
    Route::get('/transaksi/{id}/edit',[TransaksiController::class,'editAdmin'])->name('editAdmin');


    Route::get('/poin',[PoinController::class,'indexAdmin']);
    Route::post('/poin/user',[PoinController::class,'poin']);

    Route::get('/penyimpanan',[PenyimpananController::class,'index']);
    Route::get('/penyimpanan/create',[PenyimpananController::class,'create']);
    Route::post('/penyimpanan/store',[PenyimpananController::class,'store'])->name('store');
    Route::get('/penyimpanan/{id}/edit',[PenyimpananController::class,'edit']);
    Route::post('/penyimpanan/{id}/update',[PenyimpananController::class,'update'])->name('update');
    Route::delete('/penyimpanan/{id}/delete',[PenyimpananController::class,'delete'])->name('delete');
}); 

Route::prefix('/user')->middleware(['auth', 'checkLevel:pengguna'])->group(function () {
    
    Route::get('/transaksi',[TransaksiController::class,'indexUser']);
    Route::get('/transaksi/{id}/edit',[TransaksiController::class,'editUser']);
    Route::get('/poin',[PoinController::class,'indexUser']);
}); 

Route::middleware(['auth', 'checkLevel:pengguna,admin,owner'])->group(function () {

    Route::get('/dashboard',[HomeController::class,'dashboard']);
    Route::get('/password',[AuthController::class,'indexPassword']);
    Route::post('/password/update',[AuthController::class,'updatePassword'])->name('updatePassword');
    Route::get('/profil',[ProfilController::class,'index']);
    Route::post('/profil/update',[ProfilController::class,'update'])->name('update');
    Route::get('/transaksi/{id}/invoice',[TransaksiController::class,'invoice']);

    Route::get('/transaksiNota/{id}',[TransaksiController::class,'transaksiNota']);

}); 