<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Color;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Traits\PositionerTrait;

class Cercle implements ApplicableInterface
{

    use PositionerTrait;

    protected Color $text_color;
    protected Coordinates $start;
    protected int $size;

    public function setColor(Color $color): static
    {
        $this->text_color = $color;
        return $this;
    }

    public function setBgColor(Color $color): static
    {
        $this->bg_color = $color;
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
    public function setSize(int $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function apply(InvokableInterface $image): GdImage
    {
        $ellipse = (new Ellipse)->setColor($this->getColor())->setSize((new Size)->setWidth($this->size)->setHeight($this->size))->setCenter($this->start);
        return $ellipse->apply($image);
        /*
        $imager = $image();
        $color = $this->getColor();
        $color = $color($image);
        //        imageellipse($imager, $this->start->getX(), $this->start->getY(), $this->size->getWidth(), $this->size->getHeight(), $color);
        imagefilledellipse($imager, $this->start->getX(), $this->start->getY(), $this->size, $this->size, $color);
        return $imager;
        */
    }
}