<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;

class SolidImage
{
    protected $image;
    protected int $width;
    protected int $height;
    protected ?Color $bg_color=null;
    protected int $colorTransparencia;
    protected Size $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
        //$this->setWidth($width);
        //$this->setHeight($height);
        //$this->setBgColor();
    }
    public function setBgColor(Color $color): static
    {
        $this->bg_color = $color;
        return $this;
    }

    public function setWidth(int $width): static
    {
        $this->width = $width;
        return $this;
    }
    public function setHeight(int $height): static
    {
        $this->height = $height;
        return $this;
    }
    public function getBgColor(): Color
    {
        return $this->bg_color ?? (new Color)->setRed(new ColorLevel(255))->setGreen(new ColorLevel(255))->setBlue(new ColorLevel(255))->setAlpha(new TransparencyLevel(0));
    }

    public function getWidth(): int
    {
        return $this->width;
    }
    public function getHeight(): int
    {
        return $this->height;
    }

    public function __invoke()
    {
        $this->image = imagecreatetruecolor($this->size->getWidth(), $this->size->getHeight());
        if (function_exists("imageantialias")) {
            imageantialias($this->image, true);
        }
        $color = imagecolorallocate(
            $this->image,
            intval((string) $this->getBgColor()->getRed()),
            intval((string) $this->getBgColor()->getGreen()),
            intval((string) $this->getBgColor()->getBlue())
        );
        imagefill($this->image, 0, 0, $color);

        return $this->image;
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}