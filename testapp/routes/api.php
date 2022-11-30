<?php

use App\Http\Controllers\v1\OperationsController;
use App\Http\Controllers\v1\PassportAuthController;
use App\Http\Controllers\v1\ProductsController;
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

Route::prefix('v1')->group(function () {
    Route::post('register', [PassportAuthController::class, 'register'])->name('register');
    Route::post('login', [PassportAuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::get('products', [ProductsController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show');
        Route::post('products', [ProductsController::class, 'store'])->name('products.create');
        Route::patch('products/{product}', [ProductsController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.delete');
        Route::post('products/{product}/buy', [ProductsController::class, 'buy'])->name('products.buy');

        Route::get('operations', [OperationsController::class, 'index'])->name('operations.index');
    });
});
