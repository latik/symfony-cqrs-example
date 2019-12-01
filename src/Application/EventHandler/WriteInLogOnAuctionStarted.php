<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Application\Event\AuctionStarted;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class WriteInLogOnAuctionStarted implements MessageHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(AuctionStarted $event): void
    {
        $this->logger->info(sprintf('Auction started: %s', $event->getId()->toString()));
    }
}
