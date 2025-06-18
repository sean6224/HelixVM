<?php
namespace Vm\Register\Type;

/**
 * Interface RegisterValue
 *
 * Defines a contract for register value types within the virtual machine.
 * Any implementing class must provide methods to get and set the stored value.
 */
interface RegisterValue
{
    public function get(): mixed;
    public function set(mixed $value): void;
}
