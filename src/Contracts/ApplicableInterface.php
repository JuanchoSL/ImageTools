<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

use GdImage;

interface ApplicableInterface
{
    public function apply(InvokableInterface $image): GdImage;
}