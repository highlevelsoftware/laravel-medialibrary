<?php

namespace Spatie\MediaLibrary\ImageGenerators\FileTypes;

use Imagick;
use ImagickPixel;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\ImageGenerators\BaseGenerator;

class Svg extends BaseGenerator
{
    public function convert($file, Conversion $conversion = null)
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';

        $image = new Imagick();
        $image->readImage($file);
        $image->setBackgroundColor(new ImagickPixel('none'));
        $image->setImageFormat('jpg');

        file_put_contents($imageFile, $image);

        return $imageFile;
    }

    public function requirementsAreInstalled()
    {
        return class_exists('Imagick');
    }

    public function supportedExtensions()
    {
        return new Collection(['svg']);
    }

    public function supportedMimeTypes()
    {
        return new Collection(['image/svg+xml']);
    }
}
