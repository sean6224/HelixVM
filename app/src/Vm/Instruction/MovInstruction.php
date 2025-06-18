<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class MovInstruction
 *
 * Implements the MOV (Move Immediate to Register) instruction for the virtual machine.
 *
 * This instruction loads a register name and an immediate value from memory,
 * then stores the value into the specified register.
 *
 * Behavior:
 *   reg = MEM[PC];
 *   PC++;
 *   val = MEM[PC];
 *   PC++;
 *   REG[reg] = val;
 */
final class MovInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $regName = $memory->load($registers->get('PC'));
        $registers->increment('PC');

        $value = $memory->load($registers->get('PC'));
        $registers->increment('PC');

        $registers->set($regName, $value);
    }
}
