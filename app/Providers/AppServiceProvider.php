<?php

namespace App\Providers;

use App\Services\DiagnosticReport;
use App\Services\FeedbackReport;
use App\Services\ProgressReport;
use App\Services\Report;
use App\Services\ReportManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->tag([DiagnosticReport::class, ProgressReport::class, FeedbackReport::class], 'reports');
        $this->app->when(ReportManager::class)
            ->needs(Report::class)
            ->giveTagged('reports');
    }
}
