<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\ColoreableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Traits\ColoreableTrait;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Polygon implements ApplicableInterface, ColoreableInterface
{

    use PositionerTrait, ColoreableTrait;

    protected array $coordinates;

    public function setCoordinates(Coordinates ...$coordinates): static
    {
        $this->coordinates = $coordinates;
        return $this;
    }
    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();
        //$color = $this->getColor();
        //$color = $color($image);
        $color = $this->applyColor($image());
        $coordinates = [];
        foreach ($this->coordinates as $coordinate) {
            $coordinates[] = $coordinate->getX();
            $coordinates[] = $coordinate->getY();
        }
        //@imagepolygon($imager, $coordinates, count($coordinates)/2, $color);
        @imagefilledpolygon($imager, $coordinates, count($coordinates) / 2, $color);
        return $imager;
    }
}