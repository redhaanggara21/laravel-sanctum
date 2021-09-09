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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('all_user', 'AuthController@index_all');
Route::get('all_user_active', 'AuthController@index');

// Route::post('logout', 'AuthController@logout');
Route::group(['prefix' => 'auth', 'middleware' => 'auth:sanctum'], function() {
    // manggil controller sesuai bawaan laravel 8
    //Route::post('logout', [AuthController::class, 'logout']);
    Route::post('logout', 'AuthController@logout');
    // manggil controller dengan mengubah namespace di RouteServiceProvider.php biar bisa kayak versi2 sebelumnya
    Route::post('logoutall', 'AuthController@logoutall');
    Route::put('updateuser/{id}', 'AuthController@update');
});

Route::group(['prefix' => 'mydata', 'middleware' => 'auth:sanctum'], function() {
    Route::resource('/barang', Api_barang::class);
    Route::resource('/item_penjualan', Api_item_penjualan::class);
    Route::resource('/penjualan', Api_penjualan::class);
});