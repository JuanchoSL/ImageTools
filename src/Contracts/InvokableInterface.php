<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

use GdImage;

interface InvokableInterface extends ReadableInterface
{
    public function __invoke(): GdImage;
}