<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

//        \View::composer('layout.nav', function($view){
//            $user = \Auth::user();
//            $view->with('user', $user);
//        });
//
//        \View::composer('layout.sidebar', function($view){
//            $topics = \App\Topic::all();
//            $view->with('topics', $topics);
//        });

        \Carbon\Carbon::setLocale('zh');


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
//            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }
}
