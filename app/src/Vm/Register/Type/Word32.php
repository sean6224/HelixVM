<?php
declare(strict_types=1);
namespace Vm\Register\Type;

/**
 * Class Word32
 *
 * Represents a 32-bit unsigned integer value stored in a virtual machine register.
 * Implement the `RegisterValue` interface to provide consistent access to register values.
 */
final class Word32 implements RegisterValue
{
    private int $value = 0;

    public function __construct(int $value = 0)
    {
        $this->set($value);
    }

    public function get(): int
    {
        return $this->value;
    }

    public function set(mixed $value): void
    {
        $this->value = $value & 0xFFFFFFFF;
    }
}