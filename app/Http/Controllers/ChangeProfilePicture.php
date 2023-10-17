<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChangeProfilePicture extends Controller
{
    //
    public function __invoke(Request $request){

        $filePic = $request->file('profilePicInp');
        $personnel = User::find($request->id)->personnel;

        if (!Storage::exists('public/profiles')) {
            Storage::makeDirectory('profiles');
        }

        $filename = "user_{$request->id}.". $filePic->getClientOriginalExtension();
        
        Storage::putFileAs('public/profiles/', $filePic, $filename);

        $personnel->profile_pic_path = "storage/profiles/{$filename}";
        $personnel->save();

        return redirect("users/{$request->id}")->with('toastMssg','Profile Picture Changed');
        
    }
}
