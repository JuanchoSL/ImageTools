<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Dtos;

class Degrees
{
    protected int $start = 0;
    protected int $end = 0;

    public function getStart(): int
    {
        return $this->start;
    }

    public function setStart(int $start): static
    {
        $this->start = $start;
        return $this;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function setEnd(int $end): static
    {
        $this->end = $end;
        return $this;
    }
}