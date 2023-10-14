<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

## Routes Learning

    // Route::get('/', function() {
    //     return 'Welcome!';
    // });

    // Route::get();
    // Route::post();
    // Route::put(); // change the data
    // Route::patch(); // small portion of data
    // Route::delete();
    // Route::options(); // controlling methods inside your content
    // Route::match(); // pass array here, then make it as a function

    // Route::match(['get', 'post'], '/', function(){
    //     return 'POST and GET is allowed';
    // });

    // Route::any('/welcome', function() {
    //     return view('welcome');
    // }); 

    // Route::redirect('/welcome', '/');
    // Route::permanentRedirect('/welcome', '/'); // http -> https, commonly used on cpanel

    // Route::get('/home', function () {
    //     // return view('welcome');
    //     return 'Home';
    // });

    // Route::get('/about', function () {
    //     // return view('welcome');
    //     return 'About';
    // });

    // Route::get('/users', function(Request $request) {
    //     dd($request); // debugger
    //     return null;
    // });

    // Route::get('/user/{id}/{group}', function($id, $group) {
    //     return response($id.'-'.$group, 200);
    // });

    // Route::get('/request-json', function() {
    //     return response()->json(['name' => 'Dogshit', 'dog' => 'You']);
    // });

    // Route::get('/request-download', function(){
    //     $path = public_path().'/sample.txt';
    //     $name = 'sample.txt';
    //     $headers = array(
    //         'Content-type : application/text-plain'
    //     );
    //     return response()->download($path, $name, $headers);
    // });

    // Route::get('/users', 'UserController@index'); // Oldway

    # authentication, refer to auth.php
    // Route::get('/user/{id}', [UserController::class, 'show'])->middleware('auth');

##


Route::get('/', function(){
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('login');

Route::get('/user/{id}', [UserController::class, 'show2']);

// Student Route
Route::get('/students', [StudentController::class, 'whereID']);
Route::get('/student/{id}', [StudentController::class, 'show']);
