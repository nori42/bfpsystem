<?php

namespace App\Http\Middleware;

use App\Models\Establishment;
use App\Models\Inspection;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class RetrieveNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
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
                // Share the notifications data with all views
            // View::share('expiredCount', $expiredCount);

        return $next($request);
    }
}
