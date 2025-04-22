<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Engines;

class GifImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return imagecreatefromgif($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imagegif($this->modified, $filepath);
    }
    public function getExtension(): string
    {
        return image_type_to_extension(IMAGETYPE_GIF, false);
    }
    public function getMimetype(): string
    {
        return image_type_to_mime_type(IMAGETYPE_GIF);
    }
}