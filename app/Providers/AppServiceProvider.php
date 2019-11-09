<?php

namespace App\Providers;

use App\Facebook\PersistentDataHandler;
use Facebook\Facebook;
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
        $this->app->singleton(PersistentDataHandler::class, function () {
            return new PersistentDataHandler();
        });

        $this->app->singleton(Facebook::class, function () {
            $handler = new PersistentDataHandler();

            return new Facebook([
                'app_id' => config('services.facebook.id'),
                'app_secret' => config('services.facebook.secret'),
                'default_graph_version' => 'v2.2',
                'persistent_data_handler' => $handler,
                // Because passport requires Guzzle6
                // but Facebook only support Guzzle5 🖕
                'http_client_handler' => 'stream',
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('title', 'Agenda concerts à Paris: only Metal, Punk & Hardcore');
        View::share('description', 'Du black metal au punk hardcore, en passant par le heavy ou le death, tous les concerts de metal et punk à Paris sont sur La Scene Parisienne.');

//        \DB::listen(function ($query) {
//                dump([
//                'query' => $query->sql,
//                'bindings' => $query->bindings,
//                'time' => $query->time,
//            ]);
//        });
    }
}
