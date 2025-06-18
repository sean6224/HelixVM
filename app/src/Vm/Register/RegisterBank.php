<?php
declare(strict_types=1);

namespace Vm\Register;

use InvalidArgumentException;
use OutOfBoundsException;
use Vm\Register\Type\FloatValue;
use Vm\Register\Type\Word16;
use Vm\Register\Type\Word32;

/**
 * Class RegisterBank
 *
 * Represents a collection of CPU registers of various types,
 * supporting general purpose, system, typed, and flag registers.
 *
 * Features:
 * - Holds registers indexed by name (string)
 * - Supports aliases pointing to existing registers
 * - Provides get/set operations by register name
 * - Increment and copy operations on registers
 */
final class RegisterBank
{
    /** @var array<string, RegisterInterface> */
    private array $registers = [];

    private array $numberToName = [
        1 => 'R1',
        2 => 'R2',
        3 => 'R3',
        4 => 'R4',
        5 => 'PC',
        6 => 'SP',
        7 => 'FP',
        8 => 'TEMP',
    ];

    public function __construct()
    {
        $this->add(new SystemRegister('PC'));
        $this->add(new SystemRegister('SP'));
        $this->add(new SystemRegister('FP'));

        foreach (['R1', 'R2', 'R3', 'R4'] as $name) {
            $this->add(new GeneralRegister($name));
        }

        $this->add(new TypedRegister('IR', new Word16()));     // Instruction Register
        $this->add(new TypedRegister('SR', new Word16()));     // Status Register
        $this->add(new TypedRegister('TEMP', new Word32()));   // Temporary Register

        $this->add(new TypedRegister('F1', new FloatValue())); // Float register

        $this->addAlias('ACC',  'R1');   // Accumulator
        $this->addAlias('RET',  'R2');   // Return value / return address
        $this->addAlias('ARG1', 'R3');   // First argument
        $this->addAlias('ARG2', 'R4');   // Second argument

        $this->add(new FlagRegister());
    }

    private function add(RegisterInterface $register): void
    {
        $this->registers[$register->getName()] = $register;
    }

    private function addAlias(string $alias, string $target): void
    {
        if (!isset($this->registers[$target]))
        {
            throw new InvalidArgumentException("Target register '$target' does not exist");
        }
        $this->registers[$alias] = $this->registers[$target];
    }

    private function resolveName(string|int $nameOrNumber): string
    {
        if (is_int($nameOrNumber))
        {
            if (!isset($this->numberToName[$nameOrNumber]))
            {
                throw new OutOfBoundsException("Register number '$nameOrNumber' not mapped");
            }
            return $this->numberToName[$nameOrNumber];
        }
        return $nameOrNumber;
    }

    public function get(string|int $nameOrNumber): mixed
    {
        $name = $this->resolveName($nameOrNumber);

        if (!isset($this->registers[$name]))
        {
            throw new OutOfBoundsException("Register '$name' not found");
        }

        return $this->registers[$name]->get();
    }

    public function set(string|int $nameOrNumber, mixed $value): void
    {
        $name = $this->resolveName($nameOrNumber);

        if (!isset($this->registers[$name]))
        {
            throw new OutOfBoundsException("Register '$name' not found");
        }

        $this->registers[$name]->set($value);
    }

    public function getRegister(string|int $nameOrNumber): RegisterInterface
    {
        $name = $this->resolveName($nameOrNumber);

        if (!isset($this->registers[$name]))
        {
            throw new OutOfBoundsException("Register '$name' not found");
        }

        return $this->registers[$name];
    }

    public function increment(string|int $nameOrNumber, int $by = 1): void
    {
        $reg = $this->getRegister($nameOrNumber);
        $reg->set($reg->get() + $by);
    }

    public function copy(string|int $from, string|int $to): void
    {
        $this->set($to, $this->get($from));
    }

    public function dump(): string
    {
        $seen = [];
        $lines = [];

        foreach ($this->registers as $name => $reg)
        {
            if (in_array($reg, $seen, true))
            {
                continue;
            }
            $seen[] = $reg;

            if ($reg instanceof FlagRegister)
            {
                $flags = [];
                foreach (['ZF', 'CF', 'OF', 'SF'] as $flag)
                {
                    if ($reg->isSet(constant(FlagRegister::class . "::" . $flag)))
                    {
                        $flags[] = $flag;
                    }
                }
                $lines[] = sprintf("%-6s = %s", $name, implode('|', $flags) ?: '0');
            }
            else
            {
                $lines[] = sprintf("%-6s = %s", $name, var_export($reg->get(), true));
            }
        }

        return implode(PHP_EOL, $lines);
    }
}
