<?php
namespace Vm\Instruction;

use Vm\Memory\Memory;
use Vm\Register\FlagRegister;
use Vm\Register\RegisterBank;
use Vm\StackManager;

/**
 * Class CmpInstruction
 *
 * Implements the CMP (Compare) instruction for the virtual machine.
 * Compares the values of registers R1 and R2, and sets status flags accordingly.
 *
 * A result of the comparison is not stored, but the appropriate flags are written to the FLAGS register:
 * - ZF (Zero Flag) is set if R1 == R2.
 * - SF (Sign Flag) is set if R1 < R2.
 * - No other flags are currently set, but can be extended (e.g., OF, CF).
 *
 * This instruction affects conditional jump instructions that rely on flags.
 *
 * Example:
 *   R1 = 5
 *   R2 = 5
 *   => FLAGS = ZF
 *
 *   R1 = 3
 *   R2 = 5
 *   => FLAGS = SF
 *
 *   R1 = 6
 *   R2 = 5
 *   => FLAGS = 0 (no flags set)
 */
final class CmpInstruction implements Instruction
{
    public function execute(Memory $memory, RegisterBank $registers, StackManager $stack): void
    {
        $r1 = $registers->get('R1');
        $r2 = $registers->get('R2');
        $flags = 0;

        if ($r1 == $r2)
        {
            $flags |= FlagRegister::ZF;
        }
        if ($r1 < $r2)
        {
            $flags |= FlagRegister::SF;
        }
        if ($r1 > $r2)
        {
            // optionally OF or CF
        }

        $registers->set('FLAGS', $flags);
    }
}