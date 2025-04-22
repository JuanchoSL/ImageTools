<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

class Coordinates
{
    protected int $x = 0;
    protected int $y = 0;

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): static
    {
        $this->y = $y;
        return $this;
    }
}