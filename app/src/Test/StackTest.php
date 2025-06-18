<?php

namespace App\Test;

use Vm\Stack\Stack;

class StackTest
{
    public function run(): void
    {
        $stack = new Stack(maxSize: 10);

        $stack->on('push', function ($value, $index) {
            echo "Pushed value: " . var_export($value, true) . " at index $index\n";
        });

        $stack->on('pop', function ($value, $newSize) {
            echo "Popped value: " . var_export($value, true) . ", new stack size: $newSize\n";
        });

        $stack->on('framePush', function ($stackSize) {
            echo "New stack frame pushed at size $stackSize\n";
        });

        $stack->push(10);
        $stack->push(20);
        $stack->push(30);

        $stack->pushFrame();

        $stack->push(40);
        $stack->push(50);

        $peeked = $stack->peek(2);
        echo "Peeked top 2 values: " . implode(", ", $peeked) . "\n";

        $popped = $stack->pop();
        echo "Popped single value: " . var_export($popped[0], true) . "\n";

        $poppedFrameValues = $stack->popFrame();
        echo "Popped entire frame values: " . implode(", ", $poppedFrameValues) . "\n";

        echo $stack->dump() . "\n";
    }
}