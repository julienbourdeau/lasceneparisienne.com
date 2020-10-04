<?php

namespace App\Providers;

use App\Nova\Metrics\EventsPerMonth;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Lsp\EventOverview\EventOverview;
use Lsp\FacebookImportStatus\FacebookImportStatus;
use Lsp\FbTokenOverview\FbTokenOverview;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        parent::boot();
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
     */
    public function register()
    {
        //
    }

    /**
     * Register the Nova routes.
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
}
