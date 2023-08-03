<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/product/add',  'App\Http\Controllers\API\ProductController@addProduct');
Route::post('/product/edit',  'App\Http\Controllers\API\ProductController@editProduct');
Route::get('/product',  'App\Http\Controllers\API\ProductController@getProduct');
Route::get('/product/{id}',  'App\Http\Controllers\API\ProductController@getProductByid');
Route::delete('/product/{id}',  'App\Http\Controllers\API\ProductController@deleteProduct');
