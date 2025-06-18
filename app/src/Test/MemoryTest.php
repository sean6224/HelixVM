<?php
namespace App\Test;

use Vm\Memory\Memory;
use Vm\Memory\Segment;

class MemoryTest
{
    public function run(): void
    {
        $memory = new Memory();

        $memory->addSegment(new Segment('data', 0, 100, ['read', 'write']));
        $memory->addSegment(new Segment('code', 100, 50, ['read', 'exec']));
        $memory->addSegment(new Segment('stack', 150, 50, ['read', 'write'], true));

        $memory->on('read', function(int $address, $value) {
            echo "[Event] Read from 0x" . dechex($address) . ": $value\n";
        });
        $memory->on('write', function(int $address, $value) {
            echo "[Event] Write to 0x" . dechex($address) . ": $value\n";
        });


        $memory->store(10, 42);
        echo $memory->load(10) . PHP_EOL;

        echo $memory->dump();
    }
}