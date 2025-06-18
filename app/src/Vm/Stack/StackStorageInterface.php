<?php
namespace Vm\Stack;

/**
 * Interface StackStorageInterface
 *
 * Defines a contract for basic stack (LIFO) storage operations.
 * Intended to be used by higher-level stack abstractions.
 */
interface StackStorageInterface
{
    public function push(mixed $value): void;
    public function pop(): mixed;
    public function peek(): mixed;
    public function isEmpty(): bool;
    public function size(): int;
    public function clear(): void;
    public function toArray(): array;
}