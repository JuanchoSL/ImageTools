<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\EditableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Contracts\ReadableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\Size;

class Rectangle implements ApplicableInterface
{

    protected Color $text_color;
    protected Coordinates $start;
    protected Size $size;

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
    public function setSize(Size $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function apply(InvokableInterface $image): GdImage
    {
        $polygon = new Polygon;
        $polygon->setColor($this->getColor());
        $polygon->setCoordinates(
            (new Coordinates)->setX($this->start->getX())->setY($this->start->getY()),
            (new Coordinates)->setX($this->start->getX() + $this->size->getWidth())->setY($this->start->getY()),
            (new Coordinates)->setX($this->start->getX() + $this->size->getWidth())->setY($this->start->getY() + $this->size->getHeight()),
            (new Coordinates)->setX($this->start->getX())->setY($this->start->getY() + $this->size->getHeight())
        );

        return $polygon->apply($image);
    }
}