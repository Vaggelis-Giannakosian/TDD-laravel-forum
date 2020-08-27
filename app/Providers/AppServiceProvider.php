<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
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
        View::composer(['*'],function($view){
            $channels = Cache::rememberForever('channels',function(){
                return Channel::all();
            });
            $view->with('channels',$channels);
        });


//        Validator::extend('spafree','App\Rules\SpamFree@passes');


        // Override the email notification for verifying email
//        VerifyEmail::toMailUsing(function ($notifiable){
//            $verifyUrl = URL::temporarySignedRoute(
//                'verification.verify',
//                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
//                ['id' => $notifiable->getKey()]
//            );
//            return new EmailVerification($verifyUrl, $notifiable);
//        });

    }
}
