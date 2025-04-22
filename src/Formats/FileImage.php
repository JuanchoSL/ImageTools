<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

class FileImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return StringImage::read(file_get_contents($filepath));
    }

}