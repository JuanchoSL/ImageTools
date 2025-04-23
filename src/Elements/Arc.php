<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\Degrees;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Arc implements ApplicableInterface
{

    use PositionerTrait;

    protected Color $text_color;
    protected Coordinates $start;
    protected Size $size;
    protected Degrees $degrees;

    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function getColor(): Color
    {
        return $this->text_color;
    }

    public function setCenter(Coordinates $start): static
    {
        $this->start = $start;
        return $this;
    }
    public function setSize(Size $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function setDegrees(Degrees $degrees): static
    {
        $this->degrees = $degrees;
        return $this;
    }
    public function getDegrees(): Degrees
    {
        return $this->degrees;
    }
    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();
        $color = $this->getColor();
        $color = $color($image);
        imagearc(
            $imager,
            $this->start->getX(),
            $this->start->getY(),
            $this->size->getWidth(),
            $this->size->getHeight(),
            $this->degrees->getStart(),
            $this->degrees->getEnd(),
            $color
        );
        return $imager;
    }
}