<?php

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

Route::get('/', [App\Http\Controllers\AutoController::class, 'index']);
Route::post('/add-auto', [App\Http\Controllers\AutoController::class, 'addAuto']);
Route::get('/delete', [App\Http\Controllers\AutoController::class, 'deleteAuto']);
