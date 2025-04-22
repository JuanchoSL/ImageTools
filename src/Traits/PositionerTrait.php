<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\Traits;

trait PositionerTrait
{
    protected function calculateStartPosition(int $background_size, int $foregourd_size, ?int $position): int
    {
        if (is_null($position)) {
            $value = ($background_size - $foregourd_size) / 2;
        } elseif ($position < 0) {
            $value = ($background_size - $foregourd_size) + $position;
        } else {
            $value = $position;
        }
        return intval(ceil($value));
    }
}