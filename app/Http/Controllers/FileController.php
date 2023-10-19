<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //
    public function delete(Request $request){
        $file = File::find($request->id);
        $file->delete();
        Storage::delete("attachments/{$file->file_path}");

        return redirect($request->redirectPath)->with(['toastMssg' => 'File Deleted']);
    }
}
