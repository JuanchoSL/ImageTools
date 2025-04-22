<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\EditableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Contracts\ReadableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Line implements ApplicableInterface
{

    use PositionerTrait;

    protected Color $text_color;
    protected Coordinates $start;
    protected Coordinates $end;

    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function getColor(): Color
    {
        return $this->text_color;
    }

    public function setStartCoordinates(Coordinates $start): static
    {
        $this->start = $start;
        return $this;
    }
    public function setEndCoordinates(Coordinates $end): static
    {
        $this->end = $end;
        return $this;
    }
    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();
        $color = $this->getColor();
        $color = $color($image);
        imageline($imager, $this->start->getX(), $this->start->getY(), $this->end->getX(), $this->end->getY(), $color);
        return $imager;
    }
}