<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\ValueObjects;

use JuanchoSL\Exceptions\RangeNotSatisfiableException;
use JuanchoSL\Validators\Types\Integers\IntegerValidations;
use Stringable;

class ColorLevel implements Stringable
{

    protected int $value = 0;
    public function __construct(int $color = 0)
    {
        $validator = (new IntegerValidations)
            ->is()
            ->isValueGreatherThanOrEquals(0)
            ->isValueLessThanOrEquals(255);

        if (!$validator->getResult($color)) {
            throw new RangeNotSatisfiableException("The value is not into the supported rage [0-255]");
        }
        $this->value = $color;
    }

    public function __tostring(): string
    {
        return (string) $this->value;
    }
}