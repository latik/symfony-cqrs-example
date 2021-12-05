<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\EventInterface;
use App\Domain\Shared\UuidInterface;

/**
 * @property-read UuidInterface $id
 * @psalm-immutable
 */
final class AuctionStarted implements EventInterface
{
    public function __construct(public UuidInterface $id)
    {
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }
}
