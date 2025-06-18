<?php
declare(strict_types=1);
namespace Vm\Register;

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
        $this->add(new TypedRegister('TEMP', new Word32()));   // Temporary

        $this->add(new TypedRegister('F1', new FloatValue()));

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
        $this->registers[$alias] = $this->registers[$target];
    }

    public function get(string $name): mixed
    {
        return $this->registers[$name]->get();
    }

    public function set(string $name, mixed $value): void
    {
        $this->registers[$name]->set($value);
    }

    public function getRegister(string $name): RegisterInterface
    {
        return $this->registers[$name];
    }

    public function increment(string $name, int $by = 1): void
    {
        $reg = $this->getRegister($name);
        $reg->set($reg->get() + $by);
    }

    public function copy(string $from, string $to): void
    {
        $this->set($to, $this->get($from));
    }

    public function dump(): string
    {
        $lines = [];
        foreach ($this->registers as $name => $reg)
        {
            if ($reg instanceof FlagRegister)
            {
                $flags = [];
                foreach (['ZF', 'CF', 'OF', 'SF'] as $flag)
                {
                    if ($reg->isSet(constant(FlagRegister::class . "::" . $flag))) {
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