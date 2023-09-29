<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Owner;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    //
    public function edit(Request $request){
        $owner = Owner::find($request->id);

        return view('ownerEdit',[
            'owner' => $owner
        ]);

    }

    public function update(Request $request){
        $owner = Owner::find($request->id);

        $owner->first_name = strtoupper($request->firstName);
        $owner->middle_name =strtoupper($request->middleName) ;
        $owner->last_name = strtoupper($request->lastName);
        $owner->suffix = strtoupper($request->nameSuffix);
        $owner->contact_no = $request->contactNo;
        $owner->corporate_name = strtoupper($request->corporateName);

        $owner->save();

       return redirect('/establishments'.'/'.$owner->establishment[0]->id)->with('mssg','Owner Updated');
    }
}
