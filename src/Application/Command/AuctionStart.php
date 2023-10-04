<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use Symfony\Component\Uid\AbstractUid;

final readonly class AuctionStart implements CommandInterface
{
    public function __construct(
        public AbstractUid $id,
        public AbstractUid $userId,
    ) {
    }

    public static function create(AbstractUid $uuid, AbstractUid $userId): self
    {
        return new self(id: $uuid, userId: $userId);
    }
}
