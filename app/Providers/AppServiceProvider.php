<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\DateFilterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $filter = DateFilterService::resolve();
            $view->with([
                'globalFilter' => $filter,
                'filterStartDate' => $filter['start_date'],
                'filterEndDate' => $filter['end_date'],
                'filterLabel' => $filter['label'],
                'isFiltered' => $filter['is_custom'],
            ]);
        });
    }
}
