<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class PushInstruction
 *
 * Implements the PUSH instruction for the virtual machine.
 *
 * This instruction takes the value from register R1 and pushes it onto the stack.
 * It also increments the stack pointer (SP).
 *
 * Behavior:
 *   val = R1;
 *   stack.push(val);
 *   SP++;
 */
final class PushInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $value = $registers->get('R1');
        $stack->push($value);
        $registers->increment('SP');
    }
}