<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Menu;
use App\Language;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        view()->composer('partials.nav', function($view) {
            $view->with('menus', Menu::all()->toHierarchy());
        });

        view()->composer('partials.nav', function($view) {
            $view->with('languages', Language::all());
        });
        
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
