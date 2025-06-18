<?php
namespace Vm;

use Vm\Memory\Memory;

/**
 * Class ProgramLoader
 *
 * Loads a list of opcodes (and optionally operands) into memory,
 * typically starting from address 0 or configurable base address.
 */
final readonly class ProgramLoader
{
    public function __construct(
        private Memory $memory,
        private int $baseAddress = 0
    ) {
    }

    /**
     * Loads an array of instructions into memory.
     *
     * @param list<int> $program
     */
    public function load(array $program): void
    {
        $addr = $this->baseAddress;
        foreach ($program as $word)
        {
            $this->memory->store($addr++, $word);
        }
    }

    public function getEntryPoint(): int
    {
        return $this->baseAddress;
    }
}