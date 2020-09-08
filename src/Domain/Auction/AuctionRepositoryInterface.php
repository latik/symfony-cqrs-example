<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\UuidInterface;

interface AuctionRepositoryInterface
{
    public function find(UuidInterface $processId): ?Auction;

    public function save(Auction $state): void;
}
