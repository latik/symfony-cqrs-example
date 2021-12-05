<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger;

use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus implements EventBusInterface
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
