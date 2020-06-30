<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Model\DashboardTheme;

class MainProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer([
        //     'backend.layout.master'
        // ],function($view){
        //     $theme=DashboardTheme::first();
        //     $view->with(['theme'=>$theme]);
        // });

    }
}
