<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

use JuanchoSL\ImageTools\Contracts\WriteableInterface;

class JpegImage extends AbstractImage implements WriteableInterface
{

    public static function read(string $filepath)
    {
        return imagecreatefromjpeg($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== image_type_to_extension(IMAGETYPE_JPEG, false)) {
            $filepath .= image_type_to_extension(IMAGETYPE_JPEG, true);
        }
        return imagejpeg($this->modified, $filepath, 100);
    }
    public function getExtension(): string
    {
        return image_type_to_extension(IMAGETYPE_JPEG, false);
    }
    public function getMimetype(): string
    {
        return image_type_to_mime_type(IMAGETYPE_JPEG);
    }
}