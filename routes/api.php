<?php

use App\Http\Controllers\Api\BillingApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\StationApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('products', [ProductApiController::class, 'index']); //to fetch all the product list
Route::post('products', [ProductApiController::class, 'store']); //to add new product
Route::get('products/{id}', [ProductApiController::class, 'show']); //to fetch product info by id
Route::put('products/{id}', [ProductApiController::class, 'update']); //to update product data
Route::patch('products/{id}', [ProductApiController::class, 'delete']);

Route::post('orders', [OrderApiController::class, 'store']); //to add orders to the station/table
Route::get('orders/{id}', [OrderApiController::class, 'show']); //to get order details by id
Route::put('orders/{id}', [OrderApiController::class, 'update']); //update the order
Route::delete('orders/{id}', [OrderApiController::class, 'destroy']); //to remove order from station

Route::get('bills', [BillingApiController::class, 'index']); //fetch the paid bills of certain date
Route::get('bills/{id}', [BillingApiController::class, 'show']); //fetch Bill by id
Route::put('bills/{id}', [BillingApiController::class, 'update']); //update the unpaid bill status after checkout

Route::get('stations', [StationApiController::class, 'index']); //fetch all stations list
Route::post('stations', [StationApiController::class, 'store']); //add new station
Route::get('stations/{id}', [StationApiController::class, 'show']); //get the details of station- if occupied:get the order list
Route::patch('stations/{id}', [StationApiController::class, 'destroy']);

Route::post('login', [UserApiController::class, 'login']);
