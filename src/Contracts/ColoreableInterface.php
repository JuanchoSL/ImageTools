<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface ColoreableInterface
{
    public function setColor(ColorInterface $color): static;
    public function getColor(): ColorInterface;

}