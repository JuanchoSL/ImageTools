<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

use JuanchoSL\ImageTools\Contracts\ReadableInterface;
use JuanchoSL\ImageTools\Contracts\WriteableInterface;
use JuanchoSL\ImageTools\ValueObjects\ColorLevel;
use JuanchoSL\ImageTools\ValueObjects\TransparencyLevel;

class Color
{
    protected ColorLevel $red;
    protected ColorLevel $green;
    protected ColorLevel $blue;
    protected ?TransparencyLevel $alpha=null;

    public function setRed(ColorLevel $level)
    {
        $this->red = $level;
        return $this;
    }
    public function setGreen(ColorLevel $level)
    {
        $this->green = $level;
        return $this;
    }
    public function setBlue(ColorLevel $level)
    {
        $this->blue = $level;
        return $this;
    }
    public function setAlpha(TransparencyLevel $alpha)
    {
        $this->alpha = $alpha;
        return $this;
    }
    public function getRed(): ColorLevel
    {
        return $this->red ?? new ColorLevel();
    }
    public function getGreen(): ColorLevel
    {
        return $this->green ?? new ColorLevel();
    }
    public function getBlue(): ColorLevel
    {
        return $this->blue ?? new ColorLevel();
    }
    public function getAlpha(): ?TransparencyLevel
    {
        return $this->alpha;// ?? new TransparencyLevel(0);
    }

    public function __invoke(WriteableInterface&ReadableInterface $image){
        $imager = $image();
        if(is_null($this->alpha)){
            return imagecolorallocate(
                $imager,
                intval((string) $this->getRed()),
                intval((string) $this->getGreen()),
                intval((string) $this->getBlue())
            );
        }
        return imagecolorallocatealpha(
            $imager,
            intval((string) $this->getRed()),
            intval((string) $this->getGreen()),
            intval((string) $this->getBlue()),
            intval((string) $this->getAlpha())
        );
    }
}