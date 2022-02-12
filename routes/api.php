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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/products/custom', \App\Http\Controllers\Api\ProductController::class . '@custom');
//Route::get('/products/custom2', \App\Http\Controllers\Api\ProductController::class . '@custom2');
//Route::get('/products/custom3', \App\Http\Controllers\Api\ProductController::class . '@custom3');
//Route::get('/products/listwithcategories', \App\Http\Controllers\Api\ProductController::class . '@listWithCategories');
//Route::get('/categories/custom', \App\Http\Controllers\Api\CategoryController::class . '@custom');
//Route::get('/users/custom', \App\Http\Controllers\Api\UserController::class . '@custom');


Route::apiResources([
    "products" => \App\Http\Controllers\Api\ProductController::class,
    "categories" => \App\Http\Controllers\Api\CategoryController::class,
    "users" => \App\Http\Controllers\Api\UserController::class,
]);
