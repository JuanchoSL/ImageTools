<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface ColoreableInterface
{
    public function setColor(Color $color): static;
    public function getColor(): Color;

}