<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Interface Instruction
 *
 * Defines a contract for all virtual machine instructions.
 */
interface Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void;
}
