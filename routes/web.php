<?php

use App\Http\Controllers\ApiController;
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

// Route::get('/', function () {
//     return view('index');
// });




Route::controller(GroupController::class)->group(function () {
    Route::get('/', 'index')->name('group.index');
    Route::get('/ean/{group:ean}/{title?}', 'show')->name('group.show')->whereNumber('ean');

    Route::post('szukaj/', 'searchPost')->name('group.searchPost');
    Route::get('szukaj/{searchTerm}', 'index')->name('group.search');
});


Route::controller(ShopController::class)->group(function () {
    Route::get('sklep/', 'index')->name('shop.index');
    Route::get('sklep/{shop}/', 'show')->name('shop.show');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('sklep/{shop}/kategoria/', 'index')->name('category.index');
    Route::get('sklep/{shop}/kategoria/{category}', 'show')->name('category.show');
});



// Route::get('transfer',[MigrationController::class, 'index']);
// Route::get('transfer-multiply',[MigrationController::class, 'indexMultiply']);
