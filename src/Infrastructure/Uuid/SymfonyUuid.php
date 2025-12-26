<?php

declare(strict_types=1);

namespace App\Infrastructure\Uuid;

use App\Domain\Shared\UuidInterface;
use Stringable;
use Symfony\Component\Uid\Uuid;

final readonly class SymfonyUuid implements UuidInterface, Stringable
{
    private function __construct(private Uuid $uuid)
    {
    }

    public static function uuid4(): self
    {
        return new self(Uuid::v4());
    }

    public function toString(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
