<?php
declare(strict_types=1);
require dirname(__DIR__).'/vendor/autoload.php';

use App\Test\MemoryTest;
use App\Test\ProgramLoaderTest;
use App\Test\RegisterTest;
use App\Test\StackTest;
use App\Test\VirtualMachineTest;

/*
$memory = new MemoryTest();
$memory->run();

$stack = new StackTest();
$stack->run();

$register = new RegisterTest();
$register->run();

$programLoader = new ProgramLoaderTest();
$programLoader->run();
*/

$vm = new VirtualMachineTest();
$vm->run();




/*
Arithmetic operations, e.g. ADD, SUB, MUL, DIV
Logical operations: AND, OR, NOT
Memory operations: PUSH, POP, LOAD, STORE
Flow control: JMP, JZ, JNZ, CALL, RET
PRINT and READ instructions

Build a parser in PHP that:

Loads code in your language from a .whip file
Tokenizes it
Creates an intermediate structure (e.g., bytecode)
Create a custom virtual machine (VM) in PHP that:
Simulates the stack, registers, RAM (e.g. 256 addresses)
Executes instructions based on bytecode
Supports the call stack (CALL / RET)
Supports terminal input/output
Add dynamic optimizations

E.g., gluing a sequence of arithmetic operations at execution time into a single "super-instruction" (FUSION)
*/