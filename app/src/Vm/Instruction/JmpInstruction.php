<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class JmpInstruction
 *
 * Implements the JMP (unconditional jump) instruction for the virtual machine.
 * Set the program counter (PC) to the address specified in memory at the current PC.
 *
 * Instruction flow:
 * 1. Load the jump target address from memory at the current PC.
 * 2. Set the PC to the loaded address, effectively jumping to that instruction.
 *
 * Example:
 *   Memory[PC] = 0x0040
 *   JMP -> PC = 0x0040
 */
final class JmpInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $address = $memory->load($registers->get('PC'));
        $registers->set('PC', $address);
    }
}
