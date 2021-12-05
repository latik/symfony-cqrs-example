<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Domain\Auction\AuctionStarted;
use App\Domain\Shared\EventHandlerInterface;
use Psr\Log\LoggerInterface;

final class WriteInLogOnAuctionStarted implements EventHandlerInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(AuctionStarted $event): void
    {
        $this->logger->info(sprintf('Auction started: %s', $event->id()->toString()));
    }
}
