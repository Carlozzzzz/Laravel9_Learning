<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\teacher\QuestionerController;
use App\Http\Controllers\Teacher\QuestionnaireController;
use App\Http\Controllers\Teacher\QuizController;
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

    /**
     * Register Routes
     */
    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

});

Route::middleware(['auth'])->group(function () {
    /**
     * Logout Routes
     */
    Route::post('/logout', [LogoutController::class , 'logout'])->name('logout.perform');

    /**
     * Dashboard
     */

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    /**
     * Teacher-Quiz Routes
     */
    Route::group(['prefix' => 'teacher'], function(){
        /**
         * Teacher quiz Route
         */
        Route::group(['prefix'=> 'quiz'], function(){
            Route::get('/', [QuizController::class, 'create'])->name('quiz.index');
            Route::get('/create', [QuizController::class, 'create'])->name('quiz.create');
            Route::post('/create', [QuizController::class, 'store'])->name('quiz.store');
            Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
            Route::patch('/{quiz}/update', [QuizController::class, 'update'])->name('quiz.update');

            Route::post('/question/create', [QuestionerController::class, 'store'])->name('question.store');

        });

        /**
         * Teacher - Question and answers
         */
        Route::group(['prefix' => 'questionnaire'], function() {
            Route::post('/{quiz}/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
            Route::post('/{quiz}/update', [QuestionnaireController::class, 'update'])->name('questionnaire.update');
            
        });

        Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
            Route::post('/questionnaire/{quiz}store2', [QuestionnaireController::class, 'store2'])->name('api.questionnaire.store2');
        });
        
    });
});