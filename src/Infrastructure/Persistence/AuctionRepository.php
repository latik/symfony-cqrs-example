<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Auction\Auction;
use App\Domain\Auction\AuctionRepositoryInterface;
use App\Domain\Shared\UuidInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\AuctionRepository as DoctrineAuctionRepository;

final readonly class AuctionRepository implements AuctionRepositoryInterface
{
    public function __construct(private DoctrineAuctionRepository $doctrineRepository)
    {
    }

    public function find(UuidInterface $processId): ?Auction
    {
        return $this->doctrineRepository->find($processId);
    }

    public function save(Auction $auction): void
    {
        $this->doctrineRepository->persist($auction);
    }
}
