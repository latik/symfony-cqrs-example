<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use Ramsey\Uuid\UuidInterface;

interface StateRepository
{
    public function find(UuidInterface $processId): ?State;

    public function save(State $state): void;
}
