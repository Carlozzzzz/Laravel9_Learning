<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
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


Route::middleware(['guest'])->group(function() {
    /**
     * Login Routes
     */
    Route::get('/login', [LoginController::class , 'show'])->name('login');
    Route::post('/login', [LoginController::class , 'login'])->name('login.perform');

});

Route::middleware(['auth'])->group(function () {
    /**
     * Logout Routes
     */
    Route::post('/logout', [LogoutController::class , 'logout'])->name('logout.perform');


    /**
     * Home Routes
     */ 
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});