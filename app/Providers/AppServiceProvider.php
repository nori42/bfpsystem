<?php

namespace App\Providers;

use App\Models\Establishment;
use App\Models\Inspection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

        View::composer(
            [
            'dashboard',
            'expiredList.inpsection',
            'expiredList.firedrill',
            'establishments.index',
            'establishments.show',
            'establishments.edit',
            'establishments.create',
            'establishments.fsic.index',
            'establishments.fsic.attachment_fsic',
            'ownerEdit',
            'establishments.firedrill.index',
            'establishments.firedrill.attachment_firedrill',
            'fsec.index',
            'fsec.create',
            'fsec.show',
            'fsec.edit',
            'personnel.index',
            'personnel.show',
            'personnel.edit',
            'users.index',
            'reports.fsicReports',
            'reports.fsecReports',
            'reports.firedrillReports',
            'activityLog',
            'archived',
            'users.show',
            'printSettings'
        ], function ($view) {
            $inspectionsCount = Inspection::where('expiry_date',date('Y-m-d'))->count();
            $firedrillQuarterCount = Establishment::where('firedrill_is_expired',true)
                ->where('firedrill_type','QUARTERLY')
                ->count();
            $firedrillSemesterCount = Establishment::where('firedrill_is_expired',true)
                ->where('firedrill_type','SEMESTER')
                ->count();
            
            $expiredInspections = Inspection::whereBetween('expiry_date',[date('Y-m-d',strtotime('-10 days', time())),date('Y-m-d')])
            ->orderBy('expiry_date','desc')
            ->get();

            $expired = $expiredInspections->groupBy('expiry_date');

            $expiredCount = [
                'expiredInspections' => $expired->all(),
                'inspectionCount' => $inspectionsCount,
                'firedrillQuarterCount' => $firedrillQuarterCount,
                'firedrillSemesterCount' => $firedrillSemesterCount];

            $view->with('expiredCount', $expiredCount);
        });
        
    }
}
