<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\ColoreableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Traits\ColoreableTrait;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Line implements ApplicableInterface, ColoreableInterface
{

    use PositionerTrait, ColoreableTrait;

    protected Coordinates $start;
    protected Coordinates $end;

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
        //$color = $this->getColor();
        //$color = $color($image);
        $color = $this->applyColor($image());
        imageline($imager, $this->start->getX(), $this->start->getY(), $this->end->getX(), $this->end->getY(), $color);
        return $imager;
    }
}