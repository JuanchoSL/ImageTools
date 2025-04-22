<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Engines;

class GdImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return imagecreatefromgd($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imagegd($this->modified, $filepath);
    }
    public function getExtension(): string
    {
        return 'gd';
    }
    public function getMimetype(): string
    {
        return 'image/gd';
    }
}