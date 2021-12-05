<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger;

use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements CommandBusInterface
{
    public function __construct(private MessageBusInterface $commandBus)
    {
    }

    public function dispatch(CommandInterface $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
