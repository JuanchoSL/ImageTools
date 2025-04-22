<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;

class EmptyImage
{
    protected $image;
    protected int $width;
    protected int $height;
    protected ?Color $bg_color=null;
    protected int $colorTransparencia;

    public function __construct(int $width, int $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);
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
        return $this->bg_color ?? (new Color)->setRed(new ColorLevel(255))->setGreen(new ColorLevel(255))->setBlue(new ColorLevel(255))->setAlpha(new TransparencyLevel(127));
    }

    public function getWidth(): int
    {
        return $this->width;
    }
    public function getHeight(): int
    {
        return $this->height;
    }

    public function __invoke(): mixed
    {
        $this->image = imagecreatetruecolor($this->getWidth(), $this->getHeight());
        imagesavealpha($this->image, true);
        if (function_exists("imageantialias")) {
            imageantialias($this->image, true);
        }
        $this->colorTransparencia = imagecolorallocatealpha(
            $this->image,
            intval((string) $this->getBgColor()->getRed()),
            intval((string) $this->getBgColor()->getGreen()),
            intval((string) $this->getBgColor()->getBlue()),
            intval((string) $this->getBgColor()->getAlpha())
        );
        imagefill($this->image, 0, 0, $this->colorTransparencia);
        if (is_null($this->bg_color) or true) {
            $colorTransparencia = imagecolortransparent($this->image, $this->colorTransparencia);
        }
        return $this->image;
    }

    public function __destruct()
    {
        imagedestroy($this->image);
    }
}