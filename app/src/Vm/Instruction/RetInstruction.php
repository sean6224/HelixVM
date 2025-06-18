<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use RuntimeException;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class RetInstruction
 *
 * Implements the RET (return) instruction for the virtual machine.
 *
 * This instruction pops the return address from the stack and sets the Program Counter (PC) to it.
 * It also decrements the stack pointer (SP).
 *
 * Behavior:
 *   if (stack.isEmpty()) {
 *       throw "Stack underflow";
 *   }
 *   returnAddr = stack.pop();
 *   SP--;
 *   PC = returnAddr;
 */
final class RetInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        if ($stack->isEmpty())
        {
            throw new RuntimeException("Stack underflow");
        }
        $returnAddr = $stack->pop();
        $registers->increment('SP', -1);
        $registers->set('PC', $returnAddr);
    }
}