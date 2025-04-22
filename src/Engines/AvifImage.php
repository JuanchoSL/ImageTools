<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Engines;

class AvifImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return imagecreatefromavif($filepath);
    }

    public function save(string &$filepath): bool
    {
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== $this->getExtension()) {
            $filepath .= '.' . $this->getExtension();
        }
        return imageavif($this->modified, $filepath, 100);
    }
    public function getExtension(): string
    {
        return 'avif';
    }
    public function getMimetype(): string
    {
        return 'image/avif';
    }
}