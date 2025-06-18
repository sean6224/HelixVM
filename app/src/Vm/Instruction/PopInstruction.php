<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use RuntimeException;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class PopInstruction
 *
 * Implements the POP instruction for the virtual machine.
 *
 * This instruction pops the top value from the stack and stores it in register R1.
 * It also decrements the Stack Pointer (SP) by 1.
 * If the stack is empty, it throws a RuntimeException indicating a stack underflow.
 *
 * Behavior:
 *   if (stack.isEmpty()) {
 *       throw "Stack underflow";
 *   }
 *   R1 = stack.pop();
 *   SP--;
 */
final class PopInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        if ($stack->isEmpty())
        {
            throw new RuntimeException("Stack underflow");
        }
        $value = $stack->pop();
        $registers->set('R1', $value);
        $registers->increment('SP', -1);
    }
}