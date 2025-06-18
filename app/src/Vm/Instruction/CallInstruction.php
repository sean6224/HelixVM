<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class CallInstruction
 *
 * Implements the CALL instruction for the virtual machine.
 * Simulate a subroutine call by saving the current Program Counter (PC) to the stack
 * and jumping to the address stored in register R1.
 *
 * The return address (PC) is pushed onto the stack.
 * Then the Stack Pointer (SP) is incremented.
 * Finally, PC is set to the value in R1 to continue execution from the target address.
 *
 * Example:
 *   R1 = 0x1004
 *   PC = 0x0003
 *   => push (PC)
 *   => SP++
 *   => PC = R1
 */
final class CallInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $pc = $registers->get('PC');
        $stack->push($pc);
        $registers->increment('SP');

        $target = $registers->get('R1');
        $registers->set('PC', $target);
    }
}