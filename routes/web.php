<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[\App\Http\Controllers\ProductController::class, 'index']);
Route::post('/checkout',[\App\Http\Controllers\ProductController::class, 'checkout'])->name('checkout');
Route::post('/process-payment',[\App\Http\Controllers\ProductController::class, 'processPayment'])->name('checkout.processPayment');
Route::post('/success',[\App\Http\Controllers\ProductController::class, 'success'])->name('checkout.success');
Route::post('/cancel',[\App\Http\Controllers\ProductController::class, 'cancel'])->name('checkout.cancel');
