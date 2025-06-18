<?php
namespace Vm;

use RuntimeException;
use Vm\Instruction\InstructionSet;
use Vm\Memory\Memory;
use Vm\Register\RegisterBank;

/**
 * Class Cpu
 *
 * The central processing unit of the virtual machine.
 * Responsible for fetching, decoding, and executing instructions from memory.
 */
final readonly class Cpu
{
    public function __construct(
        private Memory $memory,
        private RegisterBank $registers,
        private StackManager $stack,
        private InstructionSet $instructions
    ) {
    }

    public function step(): void
    {
        $pc = $this->registers->get('PC');
        $opcode = $this->memory->load($pc);

        $this->registers->set('IR', $opcode);
        $this->registers->increment('PC');

        $instruction = $this->instructions->decode($opcode);
        $instruction->execute($this->memory, $this->registers, $this->stack);
    }

    public function run(int $maxCycles = 1000): void
    {
        try
        {
            for ($i = 0; $i < $maxCycles; $i++)
            {
                $this->step();
            }
        }
        catch (RuntimeException $e)
        {
            if ($e->getMessage() === "HALT")
            {
                return;
            }
            throw $e;
        }
    }

    public function reset(): void
    {
        $this->registers->set('PC', 0);
        $this->registers->set('IR', 0);
    }

    public function dumpState(): string
    {
        return $this->registers->dump();
    }
}