<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Auction\Auction;
use App\Domain\Auction\AuctionRepositoryInterface;
use App\Domain\Shared\UuidInterface;
use App\Infrastructure\Persistence\InMemory\InMemoryAuctionRepository;

final class AuctionRepository implements AuctionRepositoryInterface
{
    private InMemoryAuctionRepository $repository;

    public function __construct(InMemoryAuctionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(UuidInterface $processId): ?Auction
    {
        return $this->repository->find($processId);
    }

    public function save(Auction $state): void
    {
        $this->repository->save($state);
    }
}
