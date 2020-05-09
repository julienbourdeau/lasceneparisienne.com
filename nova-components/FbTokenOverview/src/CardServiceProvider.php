<?php

namespace Lsp\FbTokenOverview;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('fb-token-overview', __DIR__.'/../dist/js/card.js');
            Nova::style('fb-token-overview', __DIR__.'/../dist/css/card.css');
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Register the card's routes.
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/fb-token-overview')
            ->group(__DIR__.'/../routes/api.php');
    }
}
