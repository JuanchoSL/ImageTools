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

class Square implements ApplicableInterface
{

    protected Color $text_color;
    protected Coordinates $start;
    protected int $size;

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
    public function setSize(int $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function apply(InvokableInterface $image): GdImage
    {
        $rectangle = new Rectangle;
        $rectangle->setColor($this->getColor());
        $rectangle->setStartCoordinates($this->start);
        $rectangle->setSize((new Size)->setWidth($this->size)->setHeight($this->size));

        return $rectangle->apply($image);
    }
}