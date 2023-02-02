<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'loginAPI']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('me', function(Request $request) {
        return response()->json([
            'user' => $request->user()
        ], 200);
    });

    Route::post('signature', [ApiController::class, 'signature']);

    Route::get('customers', [ApiController::class, 'customers']);
    Route::post('customer', [ApiController::class, 'customerTambah']);

    Route::get('gabah', [ApiController::class, 'gabah']);

    Route::get('nota/{customer}', [ApiController::class, 'getNota']);
    Route::post('nota', [ApiController::class, 'buatNota']);
    Route::put('nota', [ApiController::class, 'updateNota']);

    Route::put('profile', [ApiController::class, 'updateProfile']);

    Route::get('logout', [AuthController::class, 'logoutAPI']);
});
