<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChalanController;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Customer Route
Route::get('customer', [CustomerController::class, 'index'])->middleware('auth')->name('customer');
Route::post('customer', [CustomerController::class, 'store'])->middleware('auth')->name('post_customer');
Route::get('customer/{customer}/edit', [CustomerController::class, 'edit'])->middleware('auth')->name('edit_customer');
Route::put('customer/{customer}', [CustomerController::class, 'update'])->middleware('auth')->name('update_customer');
Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->middleware('auth')->name('delete_customer');


// Product Route
Route::get('product', [ProductController::class, 'index'])->middleware('auth')->name('product');
Route::post('product', [ProductController::class, 'store'])->middleware('auth')->name('post_product');
Route::get('product/{product}/edit', [ProductController::class, 'edit'])->middleware('auth')->name('edit_product');
Route::put('product/{product}', [ProductController::class, 'update'])->middleware('auth')->name('update_product');
Route::delete('product/{product}', [ProductController::class, 'destroy'])->middleware('auth')->name('delete_product');

// Chalan
Route::get('chalan', [ChalanController::class, 'index'])->middleware('auth')->name('chalan');
Route::post('chalan', [ChalanController::class, 'store'])->middleware('auth')->name('post_chalan');
Route::get('chalan/{chalan}/edit', [ChalanController::class, 'edit'])->middleware('auth')->name('edit_chalan');
Route::put('chalan/{chalan}', [ChalanController::class, 'update'])->middleware('auth')->name('update_chalan');
Route::delete('chalan/{chalan}', [ChalanController::class, 'destroy'])->middleware('auth')->name('delete_chalan');
