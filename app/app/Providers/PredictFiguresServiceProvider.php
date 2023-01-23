<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Phpml\Classification\KNearestNeighbors;


class PredictFiguresServiceProvider extends ServiceProvider
{
    private const storagePath = '../storage/app/';
    private const countTrainingImages = 1000;
    private const trainingData = [
        [
            'directoryName' => 'triangles',
            'lableName' => 'triangle'
        ],
        [
            'directoryName' => 'circles',
            'lableName' => 'circle'
        ],
        [
            'directoryName' => 'squares',
            'lableName' => 'square'
        ]
    ];

    public function __construct(\Illuminate\Foundation\Application $app)
    {
        $this->app = $app;
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function predict($file)
    {
        $targetImage = $this->preparationImage($file);

        // echo "Image has been created. " . $file . " <br>";

        $samples = array();
        $labels = array();

        foreach (self::trainingData as $data) {
            $result =  $this->getSamplesImagesFromDirectory($data['directoryName'], $data['lableName']);
            $samples = array_merge($samples, $result['samples']);
            $labels = array_merge($labels, $result['labels']);
        }

        // echo "<br>Training data loaded. <br>";


        $classifier = new KNearestNeighbors();

        for ($i = 0; $i < self::countTrainingImages; $i++) {
            $classifier->train($samples, $labels);
        }

        // echo "<br>Classifier trained. <br>";

        return $classifier->predict($targetImage);
    }

    /**
     * @param  UploadedFile $file    	Uploaded file
     *
     * @return void
     */
    function saveToStorage(UploadedFile $file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->file('file')->storeAs('uploads', $fileName, 'public');
    }

    /**
     * @param  string $fileName    	Name of file
     *
     * @return array             	Array of bytes
     */
    function loadFromStorage($fileName)
    {
        return Storage::get($fileName);
    }

    /**
     * @param  string $directoryName    	Name of directory
     *
     * @return array             	        Array of files
     */
    function getSamplesImagesFromDirectory($directoryName, $labelName)
    {
        $images = Storage::files('public/ai-resources/' . $directoryName, true);

        $output = array();
        foreach ($images as $image) {;
            if (substr($image, -4) != '.png') {
                continue;
            }

            $array = $this->preparationImage(self::storagePath . $image);
            $output['samples'][] = $array;
            $output['labels'][] = $labelName;
        }

        return $output;
    }

    /**
     * @param  string $img    		Path to image
     *
     * @return array             	Array of input values
     */
    public function preparationImage($img)
    {
        $Input = array();

        $resizedImage = $this->imageresize($img, 16, 16, 75);

        imagefilter($resizedImage, IMG_FILTER_GRAYSCALE);
        $cnt = 0;
        for ($y = 0; $y < 16; $y++) {
            for ($x = 0; $x < 16; $x++) {
                $rgb = imagecolorat($resizedImage, $x, $y) / 255;
                $rgb = round($rgb, 6);
                $Input[$cnt] = $rgb;
                $cnt++;
            }
        }

        imagedestroy($resizedImage);
        return $Input;
    }

    /**
     * @param  string $image    		Path to image
     * @param  int $width    		Width of image
     * @param  int $height    		Height of image
     * @param  int $quality    		Quality of image
     *
     * @return array             	Array of input values
     */
    private function imageresize($image, $width, $height, $quality)
    {
        $src = imagecreatefrompng($image);

        $old_x = imageSX($src);
        $old_y = imageSY($src);
        if ($old_x > $old_y) {
            $thumb_w = $width;
            $thumb_h = $old_y * ($height / $old_x);
        }
        if ($old_x < $old_y) {
            $thumb_w = $old_x * ($width / $old_y);
            $thumb_h = $height;
        }
        if ($old_x == $old_y) {
            $thumb_w = $width;
            $thumb_h = $height;
        }
        $dst = ImageCreateTrueColor($thumb_w, $thumb_h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        return $dst;
    }
}
