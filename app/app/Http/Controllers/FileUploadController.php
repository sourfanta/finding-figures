<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\PredictFiguresServiceProvider;

class FileUploadController extends Controller
{
    private PredictFiguresServiceProvider $predictService;


    public function __construct(PredictFiguresServiceProvider $predictService)
    {
        $this->predictService = $predictService;
    }

    public function predictFigure(Request $req)
    {
        try {
            $req->validate([
                'file' => 'required|mimes:png|max:999999'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        if ($file = $req->file('file')) {
            echo  "File has been uploaded. File size: " . $file->getSize() . " bytes <br>";
            return "Result: " . $this->predictService->predict($file);
        }
    }
}
