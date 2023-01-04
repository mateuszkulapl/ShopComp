<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\GroupController;
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
