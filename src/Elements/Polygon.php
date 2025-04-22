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

class Polygon implements ApplicableInterface
{

    use PositionerTrait;

    protected Color $text_color;
    protected array $coordinates;

    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function getColor(): Color
    {
        return $this->text_color;
    }

    public function setCoordinates(Coordinates ...$coordinates): static
    {
        $this->coordinates = $coordinates;
        return $this;
    }
    public function apply(InvokableInterface $image): GdImage
    {
        $imager = $image();
        $color = $this->getColor();
        $color = $color($image);

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