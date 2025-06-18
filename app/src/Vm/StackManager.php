<?php
namespace Vm;

use RuntimeException;
use Vm\Memory\Memory;
use Vm\Register\RegisterBank;

final class StackManager
{
    private Memory $memory;
    private RegisterBank $registers;

    public function __construct(Memory $memory, RegisterBank $registers)
    {
        $this->memory = $memory;
        $this->registers = $registers;
    }

    public function push(int $value): void
    {
        $sp = $this->registers->get('SP');
        $this->memory->store($sp, $value);
        $this->registers->set('SP', $sp + 1);
    }

    public function pop(): int
    {
        $sp = $this->registers->get('SP');
        if ($sp === 0) {
            throw new RuntimeException("Stack underflow");
        }
        $sp -= 1;
        $value = $this->memory->load($sp);
        $this->registers->set('SP', $sp);
        return $value;
    }

    public function isEmpty(): bool
    {
        return $this->registers->get('SP') === 0;
    }

    public function size(): int
    {
        return $this->registers->get('SP');
    }
}