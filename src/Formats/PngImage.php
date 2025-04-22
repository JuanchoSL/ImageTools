<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

use JuanchoSL\ImageTools\Contracts\WriteableInterface;

class PngImage extends AbstractImage implements WriteableInterface
{

    public static function read(string $filepath)
    {
        return imagecreatefrompng($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imagepng($this->modified, $filepath, 9);
    }
    public function getExtension(): string
    {
        return image_type_to_extension(IMAGETYPE_PNG, false);
    }
    public function getMimetype(): string
    {
        return image_type_to_mime_type(IMAGETYPE_PNG);
    }
}