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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/create'. [App\Http\Controllers\UserController::class, 'createUser'])->middleware(['check-year:2022']);
Route::get('user/create'. [App\Http\Controllers\UserController::class])->middleware(['check-year:2023']);
