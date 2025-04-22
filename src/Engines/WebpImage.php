<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Engines;

class WebpImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return imagecreatefromwebp($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imagewebp($this->modified, $filepath, 100);
    }
    public function getExtension(): string
    {
        return image_type_to_extension(IMAGETYPE_WEBP, false);
    }
    public function getMimetype(): string
    {
        return image_type_to_mime_type(IMAGETYPE_WEBP);
    }
}