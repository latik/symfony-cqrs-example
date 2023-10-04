<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\EventInterface;
use App\Domain\Shared\UuidInterface;
use Symfony\Component\Uid\AbstractUid;

final readonly class AuctionStarted implements EventInterface
{
    public function __construct(public AbstractUid $id)
    {
    }
}
