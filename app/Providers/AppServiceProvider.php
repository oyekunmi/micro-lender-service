<?php

namespace App\Providers;

use App\User;
use App\Observers\UserObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
     * Boot the important services for the application.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
//        User::observe(UserObserver::class);

    }
}
