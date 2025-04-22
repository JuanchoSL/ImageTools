<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Engines;

class XpmImage extends AbstractImage
{

    public static function read(string $filepath)
    {
        return imagecreatefromxpm($filepath);
    }
    
    public function save(string $filepath)
    {
        //return imagexpm($this->modified, $filepath, 100);
    }
}