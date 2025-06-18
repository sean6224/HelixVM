<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class SubInstruction
 *
 * Implements the SUB (subtract) instruction for the virtual machine.
 *
 * This instruction subtracts the value in register R2 from the value in register R1,
 * then stores the result back into register R1.
 *
 * Behavior:
 *   R1 = R1 - R2;
 */
final class SubInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $r1 = $registers->get('R1');
        $r2 = $registers->get('R2');
        $registers->set('R1', $r1 - $r2);
    }
}