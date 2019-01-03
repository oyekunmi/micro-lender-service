<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CatchAllOptionsRequestsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       $request = app('request');
       
        /**
        * If the incoming request is an OPTIONS request
        * we will register a handler for the requested route
        */
       
        if ($request->isMethod('OPTIONS'))
        {
          app()->options($request->path(), function() { return response('', 200); });
        }
    }
}
