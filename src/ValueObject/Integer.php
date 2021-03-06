<?php

declare(strict_types=1);

namespace Payment\Core\Model;

use Cnastasi\Serializer\Contract\SimpleValueObject;
use Payment\Core\Exception\IntegerTooBig;
use Payment\Core\Exception\IntegerTooSmall;
use Payment\Core\Exception\InvalidDataType;
use const PHP_INT_MAX;
use const PHP_INT_MIN;

abstract class Integer implements SimpleValueObject
{
    private int $value;

    protected int $min = PHP_INT_MIN;

    protected int $max = PHP_INT_MAX;

    final public function __construct($value)
    {
        $this->value = $this->validate($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param int|mixed $value
     *
     * @return int
     */
    protected function validate($value): int
    {
        $castedValue = (int) $value;

        if (((string) $castedValue) !== (string) $value) {
            throw new InvalidDataType("The value '{$value}' should be an integer");
        }

        if ($castedValue < $this->min) {
            throw new IntegerTooSmall($this->min, $castedValue);
        }

        if ($castedValue > $this->max) {
            throw new IntegerTooBig($this->max, $castedValue);
        }

        return $castedValue;
    }
}
