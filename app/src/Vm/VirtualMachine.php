<?php
namespace Vm;

use Vm\Instruction\InstructionSet;
use Vm\Memory\Memory;
use Vm\Memory\Segment;
use Vm\Register\RegisterBank;

final class VirtualMachine
{
    const VERSION = '0.0.1';
    private Cpu $cpu;
    private Memory $memory;
    private RegisterBank $registers;
    private StackManager $stack;
    private InstructionSet $instructionSet;
    private ProgramLoader $loader;

    public function __construct(int $memorySize = 1024)
    {
        $this->memory = new Memory();
        $this->memory->addSegment(new Segment('.text', 0, $memorySize - 1, ['read', 'write', 'execute']));
        $this->registers = new RegisterBank();
        $this->stack = new StackManager($this->memory, $this->registers);
        $this->instructionSet = new InstructionSet()->createDefaultInstructionSet();
        $this->cpu = new Cpu($this->memory, $this->registers, $this->stack, $this->instructionSet);
        $this->loader = new ProgramLoader($this->memory);
    }

    public function loadProgram(array $program): void
    {
        $this->loader->load($program);
        $this->registers->set('PC', $this->loader->getEntryPoint());
    }

    public function run(int $maxCycles = 1000): void
    {
        echo "VM Started " . PHP_EOL;;
        $this->cpu->run($maxCycles);
    }

    public function reset(): void
    {
        $this->cpu->reset();
    }

    public function dumpState(): string
    {
        return $this->cpu->dumpState();
    }
}