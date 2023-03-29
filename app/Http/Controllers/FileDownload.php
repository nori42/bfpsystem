<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileDownload extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $path = 'attachments/'.$request->foldername.'/'.$request->attachFor.'/'.$request->filename;
        // Return the file as a download
        return Storage::download($path,$request->filename);
    }
}
