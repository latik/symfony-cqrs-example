<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Auction\Auction;
use App\Domain\Auction\AuctionRepositoryInterface;
use App\Domain\Shared\UuidInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\AuctionRepository as DoctrineAuctionRepository;

final class AuctionRepository implements AuctionRepositoryInterface
{
    private DoctrineAuctionRepository $doctrineRepository;

    public function __construct(DoctrineAuctionRepository $doctrineRepository)
    {
        $this->doctrineRepository = $doctrineRepository;
    }

    public function find($processId): ?Auction
    {
        return $this->doctrineRepository->find($processId);
    }

    public function save(Auction $auction): void
    {
        $this->doctrineRepository->persist($auction);
    }
}
