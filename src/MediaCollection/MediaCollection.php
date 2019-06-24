<?php

namespace Spatie\MediaLibrary\MediaCollection;

class MediaCollection
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $diskName = '';

    /** @var callable */
    public $mediaConversionRegistrations;

    /** @var callable */
    public $acceptsFile;

    /** @var bool */
    public $singleFile = false;

    public function __construct($name)
    {
        $this->name = $name;

        $this->mediaConversionRegistrations = function () {
        };

        $this->acceptsFile = function () {
            return true;
        };
    }

    public static function create($name)
    {
        return new static($name);
    }

    public function useDisk($diskName)
    {
        $this->diskName = $diskName;

        return $this;
    }

    public function acceptsFile(callable $acceptsFile)
    {
        $this->acceptsFile = $acceptsFile;

        return $this;
    }

    public function singleFile()
    {
        $this->singleFile = true;

        return $this;
    }

    public function registerMediaConversions(callable $mediaConversionRegistrations)
    {
        $this->mediaConversionRegistrations = $mediaConversionRegistrations;
    }
}
