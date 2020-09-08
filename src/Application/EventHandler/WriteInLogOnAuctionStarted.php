<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Application\Event\AuctionStarted;
use App\Domain\Shared\EventHandlerInterface;
use Psr\Log\LoggerInterface;

final class WriteInLogOnAuctionStarted implements EventHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(AuctionStarted $event): void
    {
        $this->logger->info(sprintf('Auction started: %s', $event->id()->toString()));
    }
}
