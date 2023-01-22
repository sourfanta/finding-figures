<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class FileUploadController extends Controller
{
    public function upload(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:png,jpg|max:2048'
        ]);

        if ($file = $req->file('file')) {

            echo "File has been uploaded. File size: " . $file->getSize() . " bytes";

            $bytes = file_get_contents($file->getRealPath());
        }
    }

    function saveToStorage(UploadedFile $file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->file('file')->storeAs('uploads', $fileName, 'public');
    }
}
