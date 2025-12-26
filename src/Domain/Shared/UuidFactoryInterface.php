<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface UuidFactoryInterface
{
    public function generate(): UuidInterface;

    public function fromString(string $uuid): UuidInterface;
}
