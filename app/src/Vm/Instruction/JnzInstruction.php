<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\FlagRegister;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class JnzInstruction
 *
 * Implements the JNZ (Jump if Not Zero) instruction for the virtual machine.
 *
 * This instruction checks the Zero Flag (ZF) in the FLAGS register.
 * - If ZF is **not set** (i.e., the result of the last comparison was not zero),
 *   it performs an unconditional jump to the address stored in register R1.
 * - If ZF **is set**, it increments the Program Counter (PC), effectively skipping the jump.
 *
 * Behavior:
 *   if (ZF == 0) {
 *       PC = R1;
 *   } else {
 *       PC++;
 *   }
 */
final class JnzInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $flags = $registers->get('FLAGS');
        if (($flags & FlagRegister::ZF) === 0)
        {
            $target = $registers->get('R1');
            $registers->set('PC', $target);
        }
        else
        {
            $registers->increment('PC');
        }
    }
}