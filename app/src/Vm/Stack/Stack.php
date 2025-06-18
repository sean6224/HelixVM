<?php
declare(strict_types=1);
namespace Vm\Stack;

use ArrayIterator;
use InvalidArgumentException;
use UnderflowException;
use IteratorAggregate;
use Traversable;
use Vm\EventDispatcher;

/**
 * Class Stack
 *
 * LIFO stack implementation with support for stack frames and event dispatching.
 * Provides push/pop/peek operations, frame management, and event listener registration.
 *
 * Key features:
 * - Operations: push, pop, peek, clear, size, isEmpty
 * - Frames: pushFrame / popFrame – group and rollback multiple values
 * - Events: push, pop, underflow, framePush, clear (with listener support)
 * - Iterable (`IteratorAggregate`) and serializable (`toArray`, `dump`)
 * - Optional size limit (`maxSize`)
 */
final class Stack implements IteratorAggregate
{
    private StackStorage $storage;
    private StackFrameManager $frameManager;
    private EventDispatcher $eventDispatcher;

    public function __construct(?int $maxSize = null)
    {
        $this->storage = new StackStorage($maxSize);
        $this->frameManager = new StackFrameManager();
        $this->eventDispatcher = new EventDispatcher();
    }

    public function push(mixed $values): void
    {
        $vals = is_array($values) ? $values : [$values];
        foreach ($vals as $value)
        {
            $this->storage->push($value);
            $this->eventDispatcher->dispatch('push', $value, $this->storage->size() - 1);
        }
    }

    public function pop(int $count = 1): array
    {
        if ($count < 1)
        {
            throw new InvalidArgumentException("Pop count must be >= 1");
        }
        $size = $this->storage->size();
        if ($size < $count)
        {
            $this->eventDispatcher->dispatch('underflow', 'pop', $count);
            throw new UnderflowException("Stack underflow: cannot pop $count elements");
        }

        $popped = [];
        for ($i = 0; $i < $count; $i++)
        {
            $val = $this->storage->pop();
            $popped[] = $val;
            $this->eventDispatcher->dispatch('pop', $val, $this->storage->size());
        }
        return array_reverse($popped);
    }

    public function peek(int $count = 1): array
    {
        if ($count < 1) {
            throw new InvalidArgumentException("Peek count must be >= 1");
        }
        $size = $this->storage->size();
        if ($size < $count)
        {
            $this->eventDispatcher->dispatch('underflow', 'peek', $count);
            throw new UnderflowException("Stack underflow: cannot peek $count elements");
        }

        $vals = [];
        $stackArray = $this->storage->toArray();
        for ($i = 0; $i < $count; $i++)
        {
            $vals[] = $stackArray[$size - 1 - $i];
        }
        return array_reverse($vals);
    }

    public function isEmpty(): bool
    {
        return $this->storage->isEmpty();
    }

    public function size(): int
    {
        return $this->storage->size();
    }

    // Stack frames:
    public function pushFrame(): void
    {
        $this->frameManager->pushFrame($this->storage->size() - 1);
        $this->eventDispatcher->dispatch('framePush', $this->storage->size());
    }

    public function popFrame(): array
    {
        if (!$this->frameManager->hasFrame())
        {
            throw new UnderflowException("No stack frame to pop");
        }
        $start = $this->frameManager->popFrame();
        $count = $this->storage->size() - $start;
        if ($count < 0)
        {
            return [];
        }
        return $this->pop($count);
    }

    public function getFrames(): array
    {
        return $this->frameManager->getFrames();
    }

    public function clear(): void
    {
        $this->storage->clear();
        $this->frameManager = new StackFrameManager();
        $this->eventDispatcher->dispatch('clear');
    }

    public function on(string $eventName, callable $callback): void
    {
        $this->eventDispatcher->addListener($eventName, $callback);
    }

    public function toArray(): array
    {
        return $this->storage->toArray();
    }

    public function dump(): string
    {
        $lines = [];
        $lines[] = "Stack dump (size={$this->size()}):";
        foreach ($this->toArray() as $idx => $value)
        {
            $lines[] = sprintf("  [%d] = %s", $idx, var_export($value, true));
        }
        $frames = $this->getFrames();
        $lines[] = "Frames starts at: [" . implode(", ", $frames) . "]";
        return implode(PHP_EOL, $lines);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->toArray());
    }
}