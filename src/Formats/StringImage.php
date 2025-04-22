<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

class StringImage extends AbstractImage
{

    public static function read(string $data)
    {
        return imagecreatefromstring($data);
    }

    public function save(string &$filepath): bool
    {
        return false;
    }
}