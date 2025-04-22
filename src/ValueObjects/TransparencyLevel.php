<?php declare(strict_types=1);

namespace JuanchoSL\ImageTools\ValueObjects;

use JuanchoSL\Exceptions\RangeNotSatisfiableException;
use JuanchoSL\Validators\Types\Integers\IntegerValidations;
use Stringable;

class TransparencyLevel implements Stringable
{

    protected int $value;
    public function __construct(int $value = 0)
    {
        $validator = (new IntegerValidations)
            ->is()
            ->isValueGreatherThanOrEquals(0)
            ->isValueLessThanOrEquals(127);

        if (!$validator->getResult($value)) {
            throw new RangeNotSatisfiableException("The value is not into the supported rage [0-127]");
        }
        $this->value = $value;
    }

    public function __tostring(): string
    {
        return (string) $this->value;
    }
}