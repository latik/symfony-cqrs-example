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

    public static function uuid(): self
    {
        return new self(Uuid::v7());
    }

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
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
