<?php
declare(strict_types=1);
namespace Vm\Register;

/**
 * Class GeneralRegister
 *
 * Represents a general-purpose register that can hold any type of value.
 * Supports getting and setting the register's value with flexible typing.
 */
final class GeneralRegister implements RegisterInterface
{
    private string $name;
    private mixed $value;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->value = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function get(): mixed
    {
        return $this->value;
    }

    public function set(mixed $value): void
    {
        $this->value = $value;
    }
}
