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

Route::get('products', [ProductApiController::class, 'index']);
Route::post('products', [ProductApiController::class, 'store']);
Route::get('products/{id}', [ProductApiController::class, 'show']);
Route::put('products/{id}', [ProductApiController::class, 'update']);

Route::post('orders', [OrderApiController::class, 'store']);
Route::get('orders/{id}', [OrderApiController::class, 'show']);
Route::delete('orders/{id}', [OrderApiController::class, 'destroy']);

Route::get('bills', [BillingApiController::class, 'show']);
Route::put('bills/{id}', [BillingApiController::class, 'update']);

Route::get('stations', [StationApiController::class, 'index']);
Route::post('products', [StationApiController::class, 'store']);
Route::get('stations/{id}', [StationApiController::class, 'show']);

Route::post('login', [UserApiController::class, 'login']);
