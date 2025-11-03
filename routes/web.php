<?php

use App\Http\Controllers\BillingController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StationController;

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

Route::get('/', [StationController::class, 'index'])->name('stations.index');

Route::get('/products', [HomeController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{products}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{products}', [ProductController::class, 'update'])->name('products.update');

Route::get('/user', [UserController::class, 'showLogInPage'])->name('LogInForm');
Route::post('/LogInAttempt', [UserController::class, 'userLogin'])->name('LogInSubmit');
Route::post('/logout', [UserController::class, 'userLogOut'])->name('logout');

Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
Route::get('/stations/{station}', [StationController::class, 'show'])->name('stations.show');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders', [OrderController::class, 'delete'])->name('orders.delete');

Route::get('/billings/{billings}', [BillingController::class, 'show'])->name('billings.initiate');
Route::put('/billings/{billings}', [BillingController::class, 'update'])->name('billings.update');
Route::get('/bills', [BillingController::class, 'showBills'])->name('bills.show');
