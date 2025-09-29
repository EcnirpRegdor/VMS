<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            // Share the view name with all views
            $view->with('currentViewName', $view->getName());
        });

        View::composer('partials.sidebar', function ($view) {
            $view->with('user', Auth::user());
        });
    }
}
