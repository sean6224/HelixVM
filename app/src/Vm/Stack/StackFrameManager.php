<?php
declare(strict_types=1);
namespace Vm\Stack;

use UnderflowException;

/**
 * Class StackFrameManager
 *
 * Manages stack frames for segmenting and grouping stack operations.
 * Each frame represents a logical boundary on the stack (e.g., function scope).
 *
 * Key features:
 * - Push/pop frame positions (based on a stack pointer)
 * - Track multiple nested frames
 * - Retrieve current frame start
 * - Check if any frames are active
 */
final class StackFrameManager
{
    /** @var array<int,int> */
    private array $frames = [];

    public function pushFrame(int $sp): void
    {
        $this->frames[] = $sp + 1;
    }

    public function popFrame(): int
    {
        if (empty($this->frames)) {
            throw new UnderflowException("No stack frame to pop");
        }
        return array_pop($this->frames);
    }

    public function currentFrameStart(): ?int
    {
        return end($this->frames) ?: null;
    }

    public function getFrames(): array
    {
        return $this->frames;
    }

    public function isEmpty(): bool
    {
        return empty($this->frames);
    }

    public function hasFrame(): bool
    {
        return !$this->isEmpty();
    }
}