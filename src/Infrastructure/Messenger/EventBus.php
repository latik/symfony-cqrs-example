<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger;

use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus implements EventBusInterface
{
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
