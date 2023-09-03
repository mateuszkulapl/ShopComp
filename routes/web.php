<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\ShopController;
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

Route::controller(GroupController::class)->group(function () {
    Route::get('/', 'index')->name('group.index');
    Route::get('/ean/{group:ean}/{title?}', 'show')->name('group.show')->whereNumber('ean');

    Route::post('szukaj/', 'searchPost')->name('group.searchPost');
    Route::get('szukaj/{searchTerm}', 'index')->name('group.search');
});


Route::controller(ShopController::class)->group(function () {
    Route::get('sklep/', 'index')->name('shop.index');
    Route::get('sklep/{shop}/', 'show')->name('shop.show')->whereNumber('shop');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('sklep/{shop}/kategoria/', 'index')->name('category.index')->whereNumber('shop');
    Route::get('sklep/{shop}/kategoria/{category}', 'show')->name('category.show')->whereNumber('shop', 'category');
});

Route::controller(CartController::class)->group(function () {
    Route::get('koszyk/{eans?}', 'index')
        ->where('eans', '([0-9]+,?)+')
        ->name('cart.index');
});
