<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AuctionStart as AuctionStartCommand;
use App\Domain\Auction\Auction;
use App\Domain\Auction\AuctionRepositoryInterface;
use App\Domain\Shared\CommandHandlerInterface;
use App\Domain\Shared\EventBusInterface;
use Psr\Log\LoggerInterface;

final class AuctionStart implements CommandHandlerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EventBusInterface $eventBus,
        private readonly AuctionRepositoryInterface $auctionRepository
    ) {
    }

    public function __invoke(AuctionStartCommand $command): void
    {
        $this->logger->info(sprintf('Try start process %s', $command->id()->toString()));

        $auction = Auction::start($command->id(), [$command->userId()]);

        $this->auctionRepository->save($auction);

        $events = $auction->releaseEvents();
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
