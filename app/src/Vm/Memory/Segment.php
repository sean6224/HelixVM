<?php
declare(strict_types=1);

namespace Vm\Memory;

/**
 * Class Segment
 *
 * Represents a memory segment within a virtual memory system, defined by a start address,
 * size, access flags, and an optional stack designation.
 *
 * ### Features:
 * - Human-readable segment name (`$name`) — e.g., `.text`, `.stack`
 * - Start address (`$start`) and size (`$size`) of the segment
 * - Automatically calculated end address (`$end`)
 * - Access flags (`read`, `write`, `execute`, etc.)
 * - Stack indicator (`$isStack`) to mark this segment as stack-related
 */
final readonly class Segment
{
    public int $end;

    public function __construct(
        public string $name,
        public int $start,
        public int $size,
        public array $flags = ['read', 'write'],
        public bool $isStack = false
    ) {
        $this->end = $start + $size - 1;
    }

    public function contains(int $address): bool
    {
        return $address >= $this->start && $address <= $this->end;
    }

    public function allows(string $flag): bool
    {
        return in_array($flag, $this->flags, true);
    }

    public function __toString(): string
    {
        return sprintf(
            "Segment '%s' [%d - %d], size=%d, flags=%s%s",
            $this->name,
            $this->start,
            $this->end,
            $this->size,
            implode(',', $this->flags),
            $this->isStack ? ', type=stack' : ''
        );
    }
}