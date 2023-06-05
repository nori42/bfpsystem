<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Establishment;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Controller
{
    //
    
    public function __invoke(Request $request)
    {
        $files = $request->file('fileUpload');
        $directory = 'estab'.$request->id.'_files';
        $for = $request->attachFor;

        error_log($for.'-fileupload');

        // Create a folder for the establishment if does not have one
        if (!Storage::exists('attachments/'.$directory)) {
            Storage::makeDirectory('attachments/'.$directory);
        }

        if($for == 'fsic')
        {
            if (!Storage::exists('attachments/'.$directory.'/'.$for)) {
                Storage::makeDirectory('attachments/'.$directory.'/fsic');
            }
            
            $directory = $directory.'/'.$for;
        }
        else if($for == 'fsec')
        {
            if (!Storage::exists('attachments/'.$directory.'/'.$for)) {
                Storage::makeDirectory('attachments/'.$directory.'/fsec');
            }

            $directory = $directory.'/'.$for;
        }
        else
        {
            if (!Storage::exists('attachments/'.$directory.'/'.$for)) {
                Storage::makeDirectory('attachments/'.$directory.'/firedrill');
            }

            $directory = $directory.'/'.$for;
        }
        //Loop Through multiple files
        foreach ($files as $file) {
            $file_m = new File();
            $attachment = new Attachment();

            $file_m->file_name = $file->getClientOriginalName();

            $file_m->file_extension = $file->extension();

            // save the path to the database
            $file_m->file_path = $directory.'/'.$file_m->file_name;

            //store the file
            Storage::putFileAs('attachments/'.$directory, $file, $file_m->file_name);

            $file_m->save();
            $attachment->file_id = $file_m->id;
            $attachment->establishment_id = $request->id;
            $attachment->attach_for = $request->attachFor;
            $attachment->save();
        }

        
        if($request->attachFor == 'fsic')
        {
            return redirect('/establishments/fsic/attachment/'.$request->id.'/fsic')->with(['toastMssg' => 'File Uploaded']);
        }
        else if($request->attachFor =='fsec')
        {
            return redirect('/establishments/fsec/attachment/'.$request->id.'/fsec')->with(['toastMssg' => 'File Uploaded']);
        }

        return redirect('/establishments'.'/'.$request->id.'/'.'firedrill/attachment')->with(['toastMssg' => 'File Uploaded']);
    }
}
