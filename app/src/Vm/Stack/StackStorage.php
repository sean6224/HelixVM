<?php
declare(strict_types=1);
namespace Vm\Stack;

use UnderflowException;
use OverflowException;

/**
 * Class StackStorage
 *
 * Low-level stack storage implementation using an array with optional size limit.
 * Provides raw push/pop/peek operations and maintains an internal stack pointer.
 *
 * Key features:
 * - Efficient LIFO operations (push, pop, peek)
 * - Optional max size with overflow protection
 * - Stack pointer management
 * - Conversion to array and reset (clear)
 */
final class StackStorage implements StackStorageInterface
{
    /** @var array<int, mixed> */
    private array $stack = [];
    private int $sp = -1;
    private ?int $maxSize;

    public function __construct(?int $maxSize = null)
    {
        $this->maxSize = $maxSize;
    }

    public function push(mixed $value): void
    {
        if ($this->maxSize !== null && $this->sp + 1 >= $this->maxSize) {
            throw new OverflowException("Stack overflow: max size $this->maxSize reached");
        }
        $this->stack[++$this->sp] = $value;
    }

    public function pop(): mixed
    {
        if ($this->sp < 0) {
            throw new UnderflowException("Stack underflow: cannot pop from empty stack");
        }
        $value = $this->stack[$this->sp];
        unset($this->stack[$this->sp--]);
        return $value;
    }

    public function peek(): mixed
    {
        if ($this->sp < 0) {
            throw new UnderflowException("Stack underflow: cannot peek empty stack");
        }
        return $this->stack[$this->sp];
    }

    public function isEmpty(): bool
    {
        return $this->sp < 0;
    }

    public function size(): int
    {
        return $this->sp + 1;
    }

    public function clear(): void
    {
        $this->stack = [];
        $this->sp = -1;
    }

    public function toArray(): array
    {
        return array_slice($this->stack, 0, $this->sp + 1);
    }
}