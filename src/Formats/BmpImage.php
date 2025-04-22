<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Formats;

use JuanchoSL\ImageTools\Contracts\WriteableInterface;

class BmpImage extends AbstractImage implements WriteableInterface
{

    public static function read(string $filepath)
    {
        return imagecreatefrombmp($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imagebmp($this->modified, $filepath, true);
    }
    public function getExtension(): string
    {
        return image_type_to_extension(IMAGETYPE_BMP, false);
    }
    public function getMimetype(): string
    {
        return image_type_to_mime_type(IMAGETYPE_BMP);
    }
}