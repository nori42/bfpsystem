<?php

namespace App\Http\Controllers;

use App\Models\BuildingPlan;
use App\Models\Establishment;
use App\Models\Firedrill;
use App\Models\Inspection;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $yearNow = date('Y');
        $monthNow = date('m');

        DB::table('establishments')
                    ->where('firedrill_type','QUARTERLY')
                    ->where('firedrill_count_yearly','<',3)
                    ->update(['firedrill_is_expired' => true]);

        $firedrillIssuedSubstation = [
            'Guadalupe' => FiredrillHelper::getIssuedFiredrillCount('GUADALUPE',$yearNow,$monthNow),
            'Labangon' => FiredrillHelper::getIssuedFiredrillCount('LABANGON',$yearNow,$monthNow),
            'Lahug' => FiredrillHelper::getIssuedFiredrillCount('LAHUG',$yearNow,$monthNow),
            'Mabolo' => FiredrillHelper::getIssuedFiredrillCount('MABOLO',$yearNow,$monthNow),
            'Pahina Central' => FiredrillHelper::getIssuedFiredrillCount('PAHINA CENTRAL',$yearNow,$monthNow),
            'Pardo' => FiredrillHelper::getIssuedFiredrillCount('PARDO',$yearNow,$monthNow),
            'Pari-an' => FiredrillHelper::getIssuedFiredrillCount('PARI-AN',$yearNow,$monthNow),
            'San Nicolas' => FiredrillHelper::getIssuedFiredrillCount('SAN NICOLAS',$yearNow,$monthNow),
            'Talamban' => FiredrillHelper::getIssuedFiredrillCount('TALAMBAN',$yearNow,$monthNow),
            'CBP' => FSICHelper::getIssuedFSICCount('CBP',$yearNow,$monthNow)
        ];

        $fsicIssuedSubstation = [
            'Guadalupe' => FSICHelper::getIssuedFSICCount('GUADALUPE',$yearNow,$monthNow),
            'Labangon' => FSICHelper::getIssuedFSICCount('LABANGON',$yearNow,$monthNow),
            'Lahug' => FSICHelper::getIssuedFSICCount('LAHUG',$yearNow,$monthNow),
            'Mabolo' => FSICHelper::getIssuedFSICCount('MABOLO',$yearNow,$monthNow),
            'Pahina Central' => FSICHelper::getIssuedFSICCount('PAHINA CENTRAL',$yearNow,$monthNow),
            'Pardo' => FSICHelper::getIssuedFSICCount('PARDO',$yearNow,$monthNow),
            'Pari-an' => FSICHelper::getIssuedFSICCount('PARI-AN',$yearNow,$monthNow),
            'San Nicolas' => FSICHelper::getIssuedFSICCount('SAN NICOLAS',$yearNow,$monthNow),
            'Talamban' => FSICHelper::getIssuedFSICCount('TALAMBAN',$yearNow,$monthNow),
            'CBP' => FSICHelper::getIssuedFSICCount('CBP',$yearNow,$monthNow)
        ];

        $substationTotalCountFiredrill = 0;
        $cbpFiredrill = FiredrillHelper::getIssuedFiredrillCount('CBP',$yearNow,$monthNow);

        $substationTotalCountInspection = 0;
        $cbpInspection = FSICHelper::getIssuedFSICCount('CBP',$yearNow,$monthNow);

        $totalEstablishments = Establishment::count();
        $totalPending = BuildingPlan::where('status','PENDING')->count();

        foreach($firedrillIssuedSubstation as $key => $value){
            $substationTotalCountFiredrill += $value;
        }
        foreach($fsicIssuedSubstation as $key => $value){
            $substationTotalCountInspection += $value;
        }

        $firedrillIssued = [
            'issuedBySubstation' => $firedrillIssuedSubstation,
            'CBP' => $cbpFiredrill,
            'totalSubstation' => $substationTotalCountFiredrill,
            'totalGrand' => $cbpFiredrill + $substationTotalCountFiredrill
        ];

        $issuedNew = FSICHelper::getIssuedNewByMonthNFSIC($yearNow,$monthNow);

        $fsicIssued = [
            'issuedBySubstation' => $fsicIssuedSubstation,
            'CBP' => $cbpInspection,
            'new' => $issuedNew,
            'totalSubstation' => $substationTotalCountInspection,
            'totalGrand' => $cbpInspection + $substationTotalCountInspection + $issuedNew
        ];

        $loggedInUsers = User::where('last_active_at', '>=', now()->subMinutes(5))->whereNotNull('last_active_at')->get();
        return view('dashboard',[
            'firedrillIssued' =>  $firedrillIssued,
            'fsicIssued' => $fsicIssued,
            'totalEstablishments' => $totalEstablishments,
            'totalPending' => $totalPending,
            'loggedInUsers' => $loggedInUsers
        ]);
    }
}
