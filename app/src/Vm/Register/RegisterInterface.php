<?php
namespace Vm\Register;

interface RegisterInterface
{
    public function getName(): string;
    public function get(): mixed;
    public function set(mixed $value): void;
}