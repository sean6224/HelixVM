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

    function createDefaultInstructionSet(): InstructionSet
    {
        $set = new InstructionSet();

        // Basic arithmetic and transfer instructions
        $set->register(0, NopInstruction::class);
        $set->register(1, MovInstruction::class);  // MOV Rn, value
        $set->register(2, SubInstruction::class);  // SUB R1, R2
        $set->register(3, AddInstruction::class);  // ADD R1, R2

        // Compare and jump instructions
        $set->register(4, CmpInstruction::class);  // CMP R1, R2
        $set->register(9, JzInstruction::class);   // JZ addr
        $set->register(10, JnzInstruction::class); // JNZ addr

        // Stack
        $set->register(5, PushInstruction::class); // PUSH R1
        $set->register(6, PopInstruction::class);  // POP -> R1

        // Function calls
        $set->register(7, CallInstruction::class); // CALL R1
        $set->register(8, RetInstruction::class);  // RET

        // Stop
        $set->register(255, HaltInstruction::class); // HALT
        return $set;
    }
}