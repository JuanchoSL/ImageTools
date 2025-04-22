<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface SizeableInterface
{
    public function setSize(Size $size): static;

}