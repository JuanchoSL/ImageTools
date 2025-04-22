<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Contracts;

interface WriteableInterface
{
    public function save(string &$filepath): bool;
}