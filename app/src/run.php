<?php
declare(strict_types=1);
require dirname(__DIR__).'/vendor/autoload.php';

use App\Test\MemoryTest;
use App\Test\RegisterTest;
use App\Test\StackTest;

$memory = new MemoryTest();
$memory->run();

$stack = new StackTest();
$stack->run();

$register = new RegisterTest();
$register->run();