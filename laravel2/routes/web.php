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

Route::get('/users', [UserController::class, 'index']);

Route::get('/user/{id}', [UserController::class, 'show2']);

// Student Route
Route::get('/students', [StudentController::class, 'index']);
// Route::get('/student/{id}', [StudentController::class, 'show']);


// Common routes naming
// index - Show all data or student
// show - show a single data or student
// create - show a form to a new user
// store - store a data
// edit - show a form to edit a data
// update - update a data
// destroy - delete a data

Route::controller(UserController::class)->group(function() {
    Route::get('/register','register');
    Route::get('/login','login')->name('login')->middleware('guest');
    Route::post('/login/process','process');
    Route::post('/logout','logout');
    Route::post('/store','store');
});

Route::controller(StudentController::class)->group(function() {
    Route::get('/', 'index')->middleware('auth');
    Route::get('/add/student', 'create');
    Route::post('/add/student', 'store');
    Route::get('/student/{id}', 'show');
    Route::put('/student/{student}', 'update');
    Route::delete('/student/{student}', 'destroy');
});