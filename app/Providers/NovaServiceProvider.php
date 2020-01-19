<?php

namespace App\Providers;

use App\Nova\Metrics\EventsPerDays;
use App\Nova\Metrics\EventsPerMonth;
use App\Nova\Metrics\NewEvents;
use App\Nova\Metrics\CountEvents;
use App\Nova\Metrics\TotalEvents;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use Lsp\EventOverview\EventOverview;
use Lsp\FacebookImportStatus\FacebookImportStatus;
use Lsp\FbTokenOverview\FbTokenOverview;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->isSuperAdmin();
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new FacebookImportStatus())->lastRun(),
            (new EventOverview())->overview(),
            (new FbTokenOverview())->overview(),
            (new EventsPerMonth())->width('full'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Spatie\BackupTool\BackupTool(),
        ];
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
