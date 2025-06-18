<?php
namespace App\Test;

use Vm\Register\RegisterBank;

class RegisterTest
{
    public function run(): void
    {
        $regs = new RegisterBank();

        $regs->set('R1', 42);
        $regs->set('R2', 100);

        $regs->increment('PC', 2);
        $regs->copy('R1', 'R3');

        $regs->set('F1', 3.14);
        $regs->set('TEMP', 0xDEADBEEF);

        echo $regs->dump();
    }
}