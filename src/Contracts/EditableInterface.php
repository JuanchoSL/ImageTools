<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

use JuanchoSL\ImageTools\Dtos\Color;

interface EditableInterface
{
    public function load($resource);
    public function invert();
    public function mirror();
    public function rotate(float $angle, Color $background_color);

    //public function watermark(string $text, Color $color);
    public function resize(?int $width = null, ?int $height = null);
}