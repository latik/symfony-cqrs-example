<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;

final readonly class AuctionStart implements CommandInterface
{
    public function __construct(
        public UuidInterface $id,
        public UuidInterface $userId,
    ) {
    }

    public static function create(UuidInterface $uuid, UuidInterface $userId): self
    {
        return new self(id: $uuid, userId: $userId);
    }
}
