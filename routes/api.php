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

Route::post('/auth/login', \App\Http\Controllers\Api\AuthController::class . '@login');


Route::middleware('api_token')->group(function () {
    Route::get('/auth/token', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'token' => $user->api_token,
            'expiresAt' => time() + 60 * 60 * 24 * 30,
        ]);
    });
});

Route::prefix('/products')->middleware('api_token')->group(function () {
    Route::get('/custom', \App\Http\Controllers\Api\ProductController::class . '@custom');
    Route::get('/custom2', \App\Http\Controllers\Api\ProductController::class . '@custom2');
    Route::get('/custom3', \App\Http\Controllers\Api\ProductController::class . '@custom3');
    Route::get('/listwithcategories', \App\Http\Controllers\Api\ProductController::class . '@listWithCategories');
});

Route::prefix('/categories')->middleware('api_token')->group(function () {
    Route::get('/custom', \App\Http\Controllers\Api\CategoryController::class . '@custom');
});

Route::prefix('/users')->middleware('api_token')->group(function () {
    Route::get('/custom', \App\Http\Controllers\Api\UserController::class . '@custom');
});

Route::apiResource('/products', \App\Http\Controllers\Api\ProductController::class)->middleware('api_token');
Route::apiResource('/categories', \App\Http\Controllers\Api\CategoryController::class)->middleware('api_token');
Route::apiResource('/users', \App\Http\Controllers\Api\UserController::class)->middleware('api_token');

//Route::apiResources([
//    "products" => \App\Http\Controllers\Api\ProductController::class,
//    "categories" => \App\Http\Controllers\Api\CategoryController::class,
//    "users" => \App\Http\Controllers\Api\UserController::class,
//]);
