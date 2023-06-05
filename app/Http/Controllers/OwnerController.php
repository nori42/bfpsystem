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
        $person = $owner->person;
        $corporate = $owner->corporate;

        $person->first_name = strtoupper($request->firstName);
        $person->middle_name =strtoupper($request->middleName) ;
        $person->last_name = strtoupper($request->lastName);
        $person->suffix = strtoupper($request->nameSuffix);
        $person->contact_no = $request->contactNoPerson;
        $person->save();

        $corporate->corporate_name = strtoupper($request->corporateName);

        $corporate->contact_no = $request->contactNoCorp;
        $corporate->save();

       return redirect('/establishments'.'/'.$owner->establishment[0]->id)->with('mssg','Owner Updated');
    }
}
