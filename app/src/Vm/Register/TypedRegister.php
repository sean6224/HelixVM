<?php
declare(strict_types=1);
namespace Vm\Register;

use Vm\Register\Type\RegisterValue;

/**
 * Class TypedRegister
 *
 * A register that encapsulates a strongly typed RegisterValue instance.
 * Implement RegisterInterface by delegating get/set operations
 * to the underlying RegisterValue object.
 */
final readonly class TypedRegister implements RegisterInterface
{
    public function __construct(
        private string $name,
        private RegisterValue $value
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function get(): mixed
    {
        return $this->value->get();
    }

    public function set(mixed $value): void
    {
        $this->value->set($value);
    }

    public function getValueObject(): RegisterValue
    {
        return $this->value;
    }
}