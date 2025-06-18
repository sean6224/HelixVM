<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\FlagRegister;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class JzInstruction
 *
 * Implements the JZ (Jump if Zero) instruction for the virtual machine.
 *
 * This instruction checks the Zero Flag (ZF) in the FLAGS register.
 * - If ZF **is set** (i.e., the result of the last comparison was zero),
 *   it jumps to the address stored in register R1.
 * - If ZF is **not set**, it increments the Program Counter (PC) to continue execution.
 *
 * Behavior:
 *   if (ZF == 1) {
 *       PC = R1;
 *   } else {
 *       PC++;
 *   }
 */
final class JzInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $flags = $registers->get('FLAGS');
        if (($flags & FlagRegister::ZF) !== 0)
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