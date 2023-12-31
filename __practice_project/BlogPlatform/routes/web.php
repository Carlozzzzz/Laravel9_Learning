<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::controller(App\Http\Controllers\BlogController::class)->group(function() {
    /**
     * 
     */
    Route::get('/', 'index')->name('home');
    Route::get('/home', 'index');
    Route::get('/blogs', 'index');
    Route::get('/post/{id}', 'show');
    Route::post('load-data', 'loadMoreData')->name('load-data');

});

Route::group(['prefix' => 'user'], function() {

    /**
     * User Posts
     */
    Route::controller(App\Http\Controllers\User\PostController::class)->group(function() {
        Route::get('/posts', 'index');
        Route::get('/post/create', 'create');
        Route::get('/post/{id}', 'show');
        Route::post('/store', 'store');
        Route::get('/post/edit/{id}', 'edit');
        Route::put('/post/update/{post}', 'update');
        Route::delete('/post/delete/{post}', 'destroy');
        Route::post('/load-data', 'loadMoreData')->name('/user/load-data');
    });

    /**
     * User Profile
     */
    Route::controller(App\Http\Controllers\User\ProfileController::class)->group(function() {
        Route::get('/profile', 'show');
        Route::put('/profile/update/{user}', 'update');
        Route::put('/profile/update1/{user}', 'update_1');
        Route::put('/profile/update2/{user}', 'update_2');
        Route::put('/profile/update3/{user}', 'update_3');
    });
});