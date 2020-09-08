<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Application\ProcessManager\State;
use App\Application\ProcessManager\StateRepository;
use App\Domain\Shared\UuidInterface;

final class InMemoryStateRepository implements StateRepository
{
    /** @var State[] */
    private static array $states = [];

    public function find(UuidInterface $processId): ?State
    {
        if (!$this->hasState($processId)) {
            return null;
        }

        return self::$states[$processId->toString()];
    }

    public function save(State $state): void
    {
        self::$states[$state->processId()->toString()] = $state;
    }

    public function reset(): void
    {
        self::$states = [];
    }

    private function hasState(UuidInterface $processId): bool
    {
        return isset(self::$states[$processId->toString()]);
    }
}
