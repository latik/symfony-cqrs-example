<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use Symfony\Component\Uid\AbstractUid;

interface AuctionRepositoryInterface
{
    public function find(AbstractUid $processId): ?Auction;

    public function save(Auction $auction): void;
}
