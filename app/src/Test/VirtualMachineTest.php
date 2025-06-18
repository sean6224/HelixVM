<?php
namespace App\Test;

use RuntimeException;
use Vm\VirtualMachine;

class VirtualMachineTest
{
    public function run(): void
    {
        $vm = new VirtualMachine(1024);

        $program = [
            1, 1, 10,   // MOV R1, 10
            1, 2, 1,    // MOV R2, 1
            1, 3, 1,    // MOV R3, 1
            7, 2, 1,    // CMP R2, R1 (herein assume opcode 7 = CMP)
            8, 22,      // JZ end (opcode 8 = JZ, address 22)
            3, 2, 3,    // ADD R2, R3
            3, 4, 3,    // ADD R4, R3 (R4 - suma)
            6, 9,       // JMP 3 (opcode 6 = JMP, address 9)
            255         // HALT
        ];

        $vm->loadProgram($program);

        try {
            $vm->run();
        } catch (RuntimeException $e)
        {
            echo "VM stopped: " . $e->getMessage() . PHP_EOL;
        }

        echo "CPU Registers after run:" . PHP_EOL;
        echo $vm->dumpState() . PHP_EOL;
    }
}