<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\EventInterface;
use App\Domain\Shared\UuidInterface;

final readonly class AuctionStarted implements EventInterface
{
    public function __construct(public UuidInterface $id)
    {
    }
}
