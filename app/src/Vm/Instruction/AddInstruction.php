<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class AddInstruction
 *
 * Implements the ADD instruction for the virtual machine.
 * Adds the value from the source register to the destination register and stores the result in the destination register.
 *
 * Operands are fetched from memory, based on the Program Counter (PC).
 * After each operand fetch, PC is incremented.
 *
 * Example:
 *   MEM[PC] = "R1"
 *   MEM[PC+1] = "R2"
 *   => R1 = R1 + R2
 */
final class AddInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $dest = $memory->load($registers->get('PC'));
        $registers->increment('PC');

        $src = $memory->load($registers->get('PC'));
        $registers->increment('PC');

        $registers->set($dest, $registers->get($dest) + $registers->get($src));
    }
}