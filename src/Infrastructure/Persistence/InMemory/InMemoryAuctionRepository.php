<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Auction\Auction;
use Symfony\Component\Uid\AbstractUid;

final class InMemoryAuctionRepository
{
    /** @var Auction[] */
    private static array $states = [];

    public function find(AbstractUid $processId): ?Auction
    {
        if (!$this->hasState($processId->toString())) {
            return null;
        }

        return self::$states[$processId->toString()];
    }

    public function save(Auction $state): void
    {
        self::$states[$state->processId()->toString()] = $state;
    }

    public function reset(): void
    {
        self::$states = [];
    }

    private function hasState(string $processId): bool
    {
        return isset(self::$states[$processId]);
    }
}
