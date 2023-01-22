<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:png,jpg|max:2048'
        ]);

        if ($file = $req->file('file')) {

            echo "File has been uploaded. File size: " . $file->getSize() . " bytes <br>";

            // $image = imagecreatefrompng($file);

            // echo "Image has been created <br>";

            // imagebmp($image, null, false);

            // $samples = [];
            // $labels = [];

            // $triangles = $this->loadAllFromStorage('triangles');
            // $circles = $this->loadAllFromStorage('circles');
            // $squares = $this->loadAllFromStorage('squares');

            // $i = 0;
            // foreach ($triangles as $key => $img) {
            //     $bytes = $this->loadFromStorage($img);
            //     $integers = $this->convertBytesToIntegerArray($bytes);
            //     $samples[$i + $key][] = $integers;
            //     $labels[$i + $key][] = 'triangle';
            //     echo count($integers) . " ";
            // }

            // foreach ($circles as  $key => $img) {
            //     $bytes = $this->loadFromStorage($img);
            //     $integers = $this->convertBytesToIntegerArray($bytes);
            //     $samples[$i + $key][] = $integers;
            //     $labels[$i + $key][] = 'circle';
            // }

            // foreach ($squares as $key => $img) {
            //     $bytes = $this->loadFromStorage($img);
            //     $integers = $this->convertBytesToIntegerArray($bytes);
            //     $samples[$i + $key][] = $integers;
            //     $labels[$i + $key][] = 'square';
            // }
            // echo "<br>Training data loaded";

            // foreach ($triangles as $key => $p) {
            //     $img = imagecreatefrompng($p);
            //     $image = imagescale($img, 256, 256);
            //     imagepng($image, $file->path());
            // }


            // $bytes = file_get_contents($file);
            // // $array = unpack("c2/n", $bytes);
            // // print_r($array);
            // $targetIntegers = $this->convertBytesToIntegerArray($bytes);
            // dd($bytes);
            // dd($targetIntegers);
            // return;
            // $classifier = new KNearestNeighbors();

            // $classifier->train($samples, $labels);
            // $classifier->train($samples, $labels);
            // $classifier->train($samples, $labels);
            // $classifier->train($samples, $labels);


            // return $classifier->predict($targetIntegers);
        }
    }

    function getArrayIntegersFromDirectory($directoryName)
    {
        $files = $this->loadAllFromStorage($directoryName);
        $integers = [];
        foreach ($files as $file) {
            $bytes = $this->loadFromStorage($file);
            $integers[] = $this->convertBytesToIntegerArray($bytes);
        }
        return $integers;
    }

    function saveToStorage(UploadedFile $file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->file('file')->storeAs('uploads', $fileName, 'public');
    }

    function loadFromStorage($fileName)
    {
        return Storage::disk('local')->get($fileName);
    }

    function loadAllFromStorage($directoryName)
    {
        return Storage::files('ai-resources/' . $directoryName);
    }

    function convertBytesToIntegerArray($bytes)
    {
        $integers = [];
        for ($i = 0; $i < strlen($bytes); $i++) {
            $integers[] = ord($bytes[$i]);
        }
        return $integers;
    }
}
