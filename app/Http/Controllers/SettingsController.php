<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    //
    public function update(Request $request){

        $jsonPath = resource_path('json\printSettings.json');
        $jsonData = File::get($jsonPath);
        $printSettings = json_decode($jsonData, true);
        
        $printSettings['settings']['CityMarshal'] = $request->cityMarshal;
        $printSettings['settings']['ChiefFSES'] = $request->chiefFSES;


        try{
            $updatedSettings = json_encode($printSettings,JSON_PRETTY_PRINT);
            File::put(resource_path('json\printSettings.json'),$updatedSettings);
        }
        catch (Exception $e){
            return view('printSettings',[
                'toastMssg' => $e->getMessage()
            ]);
        }

        return view('printSettings',[
            'toastMssg' => 'Settings Updated',
            'success' => true
        ]);
    }
}
