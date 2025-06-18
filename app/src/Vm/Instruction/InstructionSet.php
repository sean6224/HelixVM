<?php
namespace Vm\Instruction;

use RuntimeException;

/**
 * Class InstructionSet
 *
 * Manages the mapping between opcode integers and their corresponding instruction classes.
 *
 * Responsibilities:
 * - Register instruction classes with their respective opcode.
 * - Decode opcodes into instruction instances.
 *
 * Usage:
 *   $instructionSet->register(1, AddInstruction::class);
 *   $instruction = $instructionSet->decode(1); // returns an instance of AddInstruction
 */
final class InstructionSet
{
    /** @var array<int, class-string<Instruction>> */
    private array $map = [];

    public function register(int $opcode, string $instructionClass): void
    {
        $this->map[$opcode] = $instructionClass;
    }

    public function decode(int $opcode): Instruction
    {
        if (!isset($this->map[$opcode]))
        {
            throw new RuntimeException("Unknown opcode: $opcode");
        }

        $class = $this->map[$opcode];
        return new $class();
    }
}