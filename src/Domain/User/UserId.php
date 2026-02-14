<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\UuidInterface;

final readonly class UserId implements UuidInterface
{
    private function __construct(private UuidInterface $uuid)
    {
    }

    public static function create(UuidInterface $uuid): self
    {
        return new self($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid->__toString();
    }
}
