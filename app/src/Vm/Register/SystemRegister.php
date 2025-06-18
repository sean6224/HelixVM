<?php
declare(strict_types=1);
namespace Vm\Register;

/**
 * Class SystemRegister
 *
 * Represents a system-level register with a name and mutable value.
 * Implement the RegisterInterface.
 */
final class SystemRegister implements RegisterInterface
{
    private string $name;
    private mixed $value;

    public function __construct(string $name, mixed $initial = 0)
    {
        $this->name = $name;
        $this->value = $initial;
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