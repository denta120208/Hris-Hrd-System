<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['view']->composer('_main_layout', Composers\AddStatusMessage::class);
        $this->app['view']->composer('_ld_layout', Composers\AddStatusMessage::class);
        $this->app['view']->composer('_ld_clean_layout', Composers\AddStatusMessage::class);
//        $this->app['view']->composer('_main_layout', Composers\AddStatusMessage::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
