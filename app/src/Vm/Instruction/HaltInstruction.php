<?php
namespace Vm\Instruction;

use RuntimeException;
use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

final class HaltInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        throw new RuntimeException("HALT");
    }
}