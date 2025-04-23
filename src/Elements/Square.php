<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Elements;

use GdImage;
use JuanchoSL\ImageTools\Contracts\ApplicableInterface;
use JuanchoSL\ImageTools\Contracts\ColoreableInterface;
use JuanchoSL\ImageTools\Contracts\InvokableInterface;
use JuanchoSL\ImageTools\Dtos\Coordinates;
use JuanchoSL\ImageTools\Dtos\Size;
use JuanchoSL\ImageTools\Traits\ColoreableTrait;

class Square implements ApplicableInterface, ColoreableInterface
{
    use ColoreableTrait;

    protected Coordinates $start;
    protected int $size;

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