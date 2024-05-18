<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Base\BaseCrudController;
use App\Http\Controllers\Transaction\ApiController;
use App\Http\Controllers\Transaction\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


# [USE]
#
# IMPORTANT !!!
#
# Don't delete comment below if using generator
# @NAKAMACODE - F
#

/*
|--------------------------------------------------------------------------
| @Nakamacode - F
|--------------------------------------------------------------------------
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/search-domain', [ApiController::class, 'debugApi']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);


    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        # Get profile
        Route::get('/profile', [AuthController::class, 'profile']);

        #Group Module

        Route::prefix('transaction/invoice')->group(function () {
            Route::get('/', [InvoiceController::class, 'index']);
            Route::get('/{id}', [InvoiceController::class, 'show']);
            Route::post('/', [InvoiceController::class, 'store']);
            Route::put('/{id}', [InvoiceController::class, 'update']);
            Route::delete('/{id}', [InvoiceController::class, 'destroy']);
        });
        #GEN
        # Don't Delete this comment if using generator
    });
});
