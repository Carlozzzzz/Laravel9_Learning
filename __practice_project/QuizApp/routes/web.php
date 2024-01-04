<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\QuestionnaireController as StudentQuestionnaireController;
use App\Http\Controllers\Teacher\AnswerController;
use App\Http\Controllers\Teacher\ChoiceController;
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

            Route::get('/{quiz}/questions', [QuestionnaireController::class, 'index'])->name('questionnaire.index');

        });

        /**
         * Teacher - Question and answers
         */
        Route::group(['prefix' => 'questionnaire'], function() {
            Route::post('/{quiz}/getQuestionnaire', [QuestionnaireController::class, 'getQuestionnaire'])->name('questionnaire.getQuestionnaire');
            Route::post('/{quiz}/store', [QuestionnaireController::class, 'store'])->name('questionnaire.store');
            Route::post('/{quiz}/update', [QuestionnaireController::class, 'update'])->name('questionnaire.update');
            Route::post('/{question}/delete', [QuestionnaireController::class, 'delete'])->name('questionnaire.delete');
            
        });

        Route::group(['prefix' => 'answer'], function() {
            Route::post('/{answer}/delete', [AnswerController::class, 'delete'])->name('answer.delete');
            
        });

        Route::group(['prefix' => 'choice'], function() {
            Route::post('/{choice}/delete', [ChoiceController::class, 'delete'])->name('choice.delete');
            
        });


        Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
            Route::post('/questionnaire/{quiz}store2', [QuestionnaireController::class, 'store2'])->name('api.questionnaire.store2');
        });
        
    });

    // Route::group(['prefix' => 'teacher'], function() {
    //     Route::get('/', [QuizController::class, 'index'])->name('quiz.index');
    // });

    /**
     * Student Routes
     */

    Route::group(['prefix' => 'student'], function(){
        Route::group(['prefix' => 'quiz'], function(){
            Route::get('/index', [StudentQuizController::class, 'index'])->name('student.quiz.index');
            Route::get('/{quiz}/view', [StudentQuizController::class, 'view'])->name('student.quiz.view');
            
            
            Route::get('/{quiz}/startQuiz', [StudentQuizController::class, 'startQuiz1'])->name('student.quiz.startQuiz1');
            Route::get('/{question}/question', [StudentQuestionnaireController::class, 'getQuestion'])->name('student.quiz.question');
            
            
            
            Route::get('/{quiz}/questions', [StudentQuestionnaireController::class, 'viewQuestion'])->name('student.quiz.questions');
            Route::post('/{quiz}/startQuiz', [StudentQuizController::class, 'startQuiz'])->name('student.quiz.startQuiz');
            Route::post('/{question}/question', [StudentQuestionnaireController::class, 'getQuestionnaire'])->name('student.quiz.getQuestionnaire');
            Route::post('/{question}/prev', [StudentQuestionnaireController::class, 'prevOrNextQuestionnaire'])->name('student.quiz.prevQuestionnaire');
            Route::post('/{question}/next', [StudentQuestionnaireController::class, 'prevOrNextQuestionnaire'])->name('student.quiz.nextQuestionnaire');
        });


    });

});