<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface ReadableInterface
{
    public function getWidth(): int;
    public function getHeight(): int;
    public static function read(string $filepath);
}