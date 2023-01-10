<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::group(['controller' => AuthController::class, 'middleware' => 'guest'], function() {
    Route::get('login', 'loginPage')->name('login');
    Route::post('authenticate', 'login')->name('authenticate');
});

Route::group(['controller' => PagesController::class, 'middleware' => 'auth'], function() {
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('master/{jenis}', 'masterData')->name('master-data');
    Route::get('master/{jenis}/{id}', 'masterDataEdit')->name('master-data.edit');
    Route::put('master/{jenis}/{id}', 'masterDataUpdate')->name('master-data.update');
    Route::post('master/{jenis}', 'masterDataStore')->name('master-data.store');
    Route::delete('master/{jenis}', 'masterDataDelete')->name('master-data.delete');

    Route::get('pelanggan', 'pelanggan')->name('customers');

    Route::get('nota', 'nota')->name('arsip-nota');
    Route::get('nota/detail', 'notaDetail')->name('arsip-nota.detail');
    Route::get('nota/download/{id}', 'notaDownload')->name('arsip-nota.download');

    Route::get('laporan', 'laporan')->name('laporan');
    Route::post('laporan/download', 'laporanDownload')->name('laporan.download');

    Route::get('profile', 'profile')->name('profile');
    Route::put('profile', 'profileUpdate')->name('profile.update');

    Route::get('pengaturan', 'pengaturan')->name('pengaturan');
    Route::post('pengaturan', 'pengaturanUpdate')->name('pengaturan-update');
});

Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
