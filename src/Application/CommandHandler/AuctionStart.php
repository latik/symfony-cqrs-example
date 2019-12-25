<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AuctionStart as AuctionStartCommand;
use App\Application\Event\AuctionStarted;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AuctionStart implements MessageHandlerInterface
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function __invoke(AuctionStartCommand $command): void
    {
        $this->eventBus->dispatch(new AuctionStarted($command->id()));
    }
}
