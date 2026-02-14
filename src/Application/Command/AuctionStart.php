<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;
use App\Domain\User\UserId;

final readonly class AuctionStart implements CommandInterface
{
    public function __construct(
        public UuidInterface $id,
        public UserId $userId,
    ) {
    }

    public static function create(UuidInterface $uuid, UserId $userId): self
    {
        return new self(id: $uuid, userId: $userId);
    }
}
