<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/detail/{id}', [HomeController::class, 'detail']);
Route::get('search', [HomeController::class, 'search']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'admin']);

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index']);               // admin/product
        Route::post('/create', [ProductController::class, 'create']);       // admin/product/create
        Route::post('/update', [ProductController::class, 'update']);       // admin/product/update
        Route::post('/delete', [ProductController::class, 'delete']);       // admin/product/delete
        Route::post('/list', [ProductController::class, 'read']);           // admin/product/list
    });
});
