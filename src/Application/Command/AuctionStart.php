<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;

final readonly class AuctionStart implements CommandInterface
{
    public function __construct(
        public UuidInterface $id,
        public int $userId,
    ) {
    }

    public static function create(UuidInterface $uuid4, int $userId): self
    {
        return new self(id: $uuid4, userId: $userId);
    }
}
