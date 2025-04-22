<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface LocatableInterface
{
    public function setStartCoordinates(Coordinates $start): static;

}