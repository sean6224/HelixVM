<?php
declare(strict_types=1);
namespace Vm\Register;

/**
 * Class FlagRegister
 *
 * Represents a CPU-like flag register with common status flags.
 * Provides methods to get/set the full flags value and manipulate individual flags.
 *
 * ### Flags:
 * - ZF (Zero Flag): indicates zero result (bit 0)
 * - CF (Carry Flag): indicates carry/borrow (bit 1)
 * - OF (Overflow Flag): indicates arithmetic overflow (bit 2)
 * - SF (Sign Flag): indicates negative result (bit 3)
 */
final class FlagRegister implements RegisterInterface
{
    public const int ZF = 1 << 0;
    public const int CF = 1 << 1;
    public const int OF = 1 << 2;
    public const int SF = 1 << 3;

    private string $name = 'FLAGS';
    private int $flags = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function get(): int
    {
        return $this->flags;
    }

    public function set(mixed $value): void
    {
        $this->flags = (int)$value;
    }

    public function setFlag(int $flag): void
    {
        $this->flags |= $flag;
    }

    public function clearFlag(int $flag): void
    {
        $this->flags &= ~$flag;
    }

    public function isSet(int $flag): bool
    {
        return (bool)($this->flags & $flag);
    }

    public function reset(): void
    {
        $this->flags = 0;
    }
}