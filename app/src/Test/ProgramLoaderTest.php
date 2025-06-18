<?php
namespace App\Test;

use Vm\Cpu;
use Vm\Instruction\InstructionSet;
use Vm\Memory\Memory;
use Vm\Memory\Segment;
use Vm\ProgramLoader;
use Vm\Register\RegisterBank;
use Vm\StackManager;

class ProgramLoaderTest
{
    public function run(): void
    {
        $memory = new Memory();
        $memory->addSegment(new Segment('.text', 0, 1023, ['read', 'write', 'exec'])); // np. 1 KB memories

        $registers = new RegisterBank();
        $stack = new StackManager($memory, $registers);
        $instructions = new InstructionSet();
        $instructions = $instructions->createDefaultInstructionSet();
        $cpu = new Cpu($memory, $registers, $stack, $instructions);

        $program = [
            1, 1, 42,   // MOV R1, 42
            1, 2, 10,   // MOV R2, 10
            3, 1, 2,    // ADD R1, R2
            255         // HALT
        ];

        $loader = new ProgramLoader($memory);
        $loader->load($program);

        $registers->set('PC', $loader->getEntryPoint());
        $cpu->run();
    }
}