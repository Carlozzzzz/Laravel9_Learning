<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

/**
 * Rutes naming convention
 * 
 * index(): Display a listing of the resource.
 * create(): Show the form for creating a new resource.
 * store(): Store a newly created resource in storage.
 * show($id): Display the specified resource.
 * edit($id): Show the form for editing the specified resource.
 * update($id): Update the specified resource in storage.
 * destroy($id): Remove the specified resource from storage.
 * 
 */



Route::post('/login', [AuthController::class, 'login']);
Route::get('/', [AuthController::class, 'show'])->name('login');

// Middleware Group Auth

Route::group(['middleware' => ['auth']], function() {
    
    /**
     * Logout Route
     */
    Route::get('/logout', [AuthController::class, 'logout']);


    /**
     * Dashboard Route
     * 
     * @sample => Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware('auth');
     * 
     */
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);


    /**
     * User Routes 
     */

    Route::controller(UserController::class)->group(function() {
        
        // User routes ...
        Route::get('/users', 'index');
        Route::get('/users/create', 'create');
        Route::post('/users/store', 'store');
    });

});