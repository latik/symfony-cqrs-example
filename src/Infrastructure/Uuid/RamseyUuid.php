<?php

declare(strict_types=1);

namespace App\Infrastructure\Uuid;

use App\Domain\Shared\UuidInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;
use Stringable;

final class RamseyUuid implements UuidInterface, Stringable
{
    private function __construct(private readonly RamseyUuidInterface $uuid)
    {
    }

    public static function uuid4(): self
    {
        return new self(Uuid::getFactory()->uuid4());
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
