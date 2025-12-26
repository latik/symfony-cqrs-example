<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Auction\Auction;
use App\Domain\Shared\UuidInterface;

final class InMemoryAuctionRepository
{
    /** @var Auction[] */
    private static array $states = [];

    public function find(UuidInterface $processId): ?Auction
    {
        if (!$this->hasState((string) $processId)) {
            return null;
        }

        return self::$states[(string) $processId];
    }

    public function save(Auction $state): void
    {
        self::$states[(string) $state->processId()] = $state;
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
