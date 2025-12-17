<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//todo: move to sanctum protected routes instead of token
Route::resource('store', ApiController::class)->only('store')->name('store', 'api.store');
Route::post('storemultiply', [ApiController::class, 'storeMultiply']);
