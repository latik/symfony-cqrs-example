<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AuctionStart as AuctionStartCommand;
use App\Application\Event\AuctionStarted;
use App\Domain\Shared\CommandHandlerInterface;
use App\Domain\Shared\EventBusInterface;

final class AuctionStart implements CommandHandlerInterface
{
    private EventBusInterface $eventBus;

    public function __construct(EventBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(AuctionStartCommand $command): void
    {
        $this->eventBus->dispatch(new AuctionStarted($command->id()));
    }
}
