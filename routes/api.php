<?php

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

Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'authenticate']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('profile', [\App\Http\Controllers\Api\AuthController::class, 'get_user']);
    Route::get('orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
    Route::post('orders/create', [\App\Http\Controllers\Api\OrderController::class, 'store']);
    Route::post('ratings/create', [\App\Http\Controllers\Api\RatingController::class, 'store']);
});
Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'show']);
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
// });
