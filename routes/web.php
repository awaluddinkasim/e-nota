<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

Route::group(['controller' => AuthController::class, 'middleware' => 'guest'], function () {
    Route::get('login', 'loginPage')->name('login');
    Route::post('authenticate', 'login')->name('authenticate');
});

Route::group(['controller' => AdminController::class, 'middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('master/{jenis}', 'masterData')->name('master-data');
    Route::get('master/{jenis}/{id}', 'masterDataEdit')->name('master-data.edit');
    Route::put('master/{jenis}/{id}', 'masterDataUpdate')->name('master-data.update');
    Route::post('master/{jenis}', 'masterDataStore')->name('master-data.store');
    Route::delete('master/{jenis}', 'masterDataDelete')->name('master-data.delete');

    Route::get('pelanggan', 'pelanggan')->name('customers');
    Route::get('pelanggan/{id}/nota', 'nota')->name('customer.arsip-nota');
    Route::get('pelanggan/{id}/nota/detail', 'notaDetail')->name('customer.arsip-nota.detail');
    Route::get('pelanggan/nota/download/{id}', 'notaDownload')->name('customer.arsip-nota.download');

    Route::get('laporan', 'laporan')->name('laporan');
    Route::post('laporan/download', 'laporanDownload')->name('laporan.download');

    Route::get('profile', 'profile')->name('profile');
    Route::put('profile', 'profileUpdate')->name('profile.update');

    Route::get('pengaturan', 'pengaturan')->name('pengaturan');
    Route::post('pengaturan', 'pengaturanUpdate')->name('pengaturan-update');
});

Route::group(['controller' => TokoController::class, 'middleware' => ['auth', 'admin-toko']], function () {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('pedagang', 'pedagang')->name('pedagang');
    Route::post('pedagang', 'pedagangStore')->name('pedagang.store');
    Route::get('pedagang/{id}', 'pedagangEdit')->name('pedagang.edit');
    Route::put('pedagang/{id}', 'pedagangUpdate')->name('pedagang.update');
    Route::delete('pedagang', 'pedagangDelete')->name('pedagang.delete');

    Route::get('pelanggan', 'pelanggan')->name('customers');
    Route::get('pelanggan/{id}/nota', 'nota')->name('customer.arsip-nota');
    Route::get('pelanggan/{id}/nota/detail', 'notaDetail')->name('customer.arsip-nota.detail');
    Route::get('pelanggan/nota/download/{id}', 'notaDownload')->name('customer.arsip-nota.download');

    Route::get('laporan', 'laporan')->name('laporan');
    Route::post('laporan/download', 'laporanDownload')->name('laporan.download');

    Route::get('pengaturan', 'pengaturan')->name('pengaturan');
    Route::put('pengaturan', 'pengaturanUpdate')->name('pengaturan.update');

    Route::get('profile', 'profile')->name('profile');
    Route::put('profile', 'profileUpdate')->name('profile.update');
});

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
