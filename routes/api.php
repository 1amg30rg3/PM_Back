<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\categoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/product/get',[ProductController::class, 'products']);
// Route::post('/product/create',[ProductController::class, 'create']);
// Route::get('/product/get/{id}',[ProductController::class, 'show']);
// Route::delete('/product/delete/{id}',[ProductController::class, 'show']);

Route::prefix('product')->group(function () {
    Route::get('get', [ProductController::class, 'index']);
    Route::post('create', [ProductController::class, 'store']);
    Route::get('get/{id}', [ProductController::class, 'show']);
    Route::delete('delete/{id}', [ProductController::class, 'destroy']);
});

Route::prefix('category')->group(function () {
    Route::get('get', [categoryController::class, 'index']);
    Route::post('store', [categoryController::class, 'store']);
});