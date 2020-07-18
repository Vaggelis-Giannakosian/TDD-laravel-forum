<?php

namespace App\Providers;

use App\Channel;
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
//        View::composer(['threads.create','threads.index','*'],function($view){
//            $view->with('channels',Channel::all());
//        });

        if(app()->environment() !== 'testing')
        {
            View::share('channels', Channel::all());
        }
    }
}
