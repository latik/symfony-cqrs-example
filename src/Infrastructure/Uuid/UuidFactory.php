<?php

declare(strict_types=1);

namespace App\Infrastructure\Uuid;

use App\Domain\Shared\UuidFactoryInterface;
use App\Domain\Shared\UuidInterface;

final class UuidFactory implements UuidFactoryInterface
{
    public function generate(): UuidInterface
    {
        return SymfonyUuid::uuid4();
    }
}
