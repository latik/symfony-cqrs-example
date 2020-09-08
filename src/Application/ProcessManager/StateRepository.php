<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use App\Domain\Shared\UuidInterface;

interface StateRepository
{
    public function find(UuidInterface $processId): ?State;

    public function save(State $state): void;
}
