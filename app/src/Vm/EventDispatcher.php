<?php
declare(strict_types=1);
namespace Vm;

final class EventDispatcher
{
    /** @var array<string, callable[]> */
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(string $eventName, ...$args): void
    {
        foreach ($this->listeners[$eventName] ?? [] as $listener) {
            $listener(...$args);
        }
    }
}