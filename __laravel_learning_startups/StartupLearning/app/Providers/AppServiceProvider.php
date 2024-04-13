<?php

namespace App\Providers;

use App\Models\Students;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Can use DB here to be shared in inside the app
        // Common data for all
        View::share('title', 'Student Admin');

        // Rekta query na sya pag nag call ka ng index method
        // part 6 - 47mins
        // View::composer('students.index', function($view) {
        //     $view->with('students', ['data' => Students::all()]);
        // });
    }
}
