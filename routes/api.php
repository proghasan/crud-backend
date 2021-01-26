<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ProductController;
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

Route::post("registration", [AppController::class, 'registration']);
Route::post("login", [AppController::class, 'login']);

Route::group(['middleware' => ['AuthJwt']], function(){
    Route::get('logout', [AppController::class, 'logout']);

    // product 
    Route::post("save-product", [ProductController::class, 'save']);
    Route::put("update-product", [ProductController::class, 'update']);
    Route::delete("delete-product/{id}", [ProductController::class, 'delete']);
    Route::get("products", [ProductController::class, 'products']);
    Route::get("product/{id}", [ProductController::class, 'product']);
});