<?php
declare(strict_types=1);
namespace Vm\Register\Type;

/**
 * Class FloatValue
 *
 * Represents a floating-point value stored in a virtual machine register.
 * Implement the `RegisterValue` interface, enabling uniform handling of different register value types.
 */
final class FloatValue implements RegisterValue
{
    private float $value;

    public function __construct(float $value = 0.0)
    {
        $this->value = $value;
    }

    public function get(): float
    {
        return $this->value;
    }

    public function set(mixed $value): void
    {
        $this->value = (float)$value;
    }
}