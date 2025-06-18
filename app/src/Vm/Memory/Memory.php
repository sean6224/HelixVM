<?php
declare(strict_types=1);
namespace Vm\Memory;

use OutOfBoundsException;
use RuntimeException;
use Vm\EventDispatcher;

final class Memory
{
    /** @var Segment[] */
    private array $segments = [];

    /** @var array<int, mixed> */
    private array $data = [];

    private EventDispatcher $events;

    public function __construct()
    {
        $this->events = new EventDispatcher();
    }

    public function addSegment(Segment $segment): void
    {
        // check for overlapping segments
        foreach ($this->segments as $existing)
        {
            if (
                ($segment->start <= $existing->end && $segment->start >= $existing->start) ||
                ($segment->end <= $existing->end && $segment->end >= $existing->start)
            ) {
                throw new RuntimeException("Segment '$segment->name' overlaps with '$existing->name'");
            }
        }
        $this->segments[] = $segment;
    }

    public function on(string $eventName, callable $callback): void
    {
        $this->events->addListener($eventName, $callback);
    }

    private function trigger(string $eventName, ...$args): void
    {
        $this->events->dispatch($eventName, ...$args);
    }

    private function findSegment(int $address): ?Segment
    {
        return array_find($this->segments, fn($segment) => $segment->contains($address));
    }

    public function load(int $address): mixed
    {
        $segment = $this->findSegment($address);
        if (!$segment)
        {
            $this->trigger('outOfBounds', $address, 'read');
            throw new OutOfBoundsException("Address $address is out of memory bounds");
        }
        if (!$segment->allows('read'))
        {
            $this->trigger('accessViolation', $address, 'read', $segment->name);
            throw new RuntimeException("Read access violation at address $address in segment '$segment->name'");
        }
        $value = $this->data[$address] ?? 0;
        $this->trigger('read', $address, $value);
        return $value;
    }

    public function store(int $address, mixed $value): void
    {
        $segment = $this->findSegment($address);
        if (!$segment)
        {
            $this->trigger('outOfBounds', $address, 'write');
            throw new OutOfBoundsException("Address $address is out of memory bounds");
        }
        if (!$segment->allows('write'))
        {
            $this->trigger('accessViolation', $address, 'write', $segment->name);
            throw new RuntimeException("Write access violation at address $address in segment '$segment->name'");
        }
        $this->data[$address] = $value;
        $this->trigger('write', $address, $value);
    }

    public function dump(): string
    {
        $result = [];
        foreach ($this->segments as $segment)
        {
            $result[] = (string)$segment;
            for ($i = $segment->start; $i <= $segment->end; $i++)
            {
                $val = $this->data[$i] ?? 0;
                $result[] = sprintf("  0x%04X: %s", $i, var_export($val, true));
            }
        }
        return implode(PHP_EOL, $result);
    }
}