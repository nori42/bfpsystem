<?php

namespace App\Providers;

use App\Models\Establishment;
use App\Models\Inspection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        //
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        if(Schema::hasTable('inspections') && Schema::hasTable('establishments')){
            View::share('expiredCount',HelperProvider::getNotifications());
        }
    }
}
