<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

class Size
{
    protected int $x = 0;
    protected int $y = 0;

    public function getWidth(): int
    {
        return $this->x;
    }

    public function setWidth(int $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getHeight(): int
    {
        return $this->y;
    }

    public function setHeight(int $y): static
    {
        $this->y = $y;
        return $this;
    }
}