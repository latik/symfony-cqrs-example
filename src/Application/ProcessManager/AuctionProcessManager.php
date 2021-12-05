<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use App\Application\Command\AuctionStart;
use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\EventInterface;
use App\Domain\Shared\MessageSubscriberInterface;
use App\Domain\Shared\UuidFactoryInterface;
use App\Domain\User\UserConnected;
use App\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

final class AuctionProcessManager implements MessageSubscriberInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private UuidFactoryInterface $uuidFactory,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(EventInterface $event)
    {
        foreach (self::getHandledMessages() as $className => $config) {
            if ($className === \get_class($event)) {
                self::{$config['method']}($event);
            }
        }
    }

    public static function getHandledMessages(): iterable
    {
        yield UserConnected::class => ['method' => 'handleThatUserConnected', 'bus' => 'event.bus'];
    }

    public function handleThatUserConnected(UserConnected $event): void
    {
        $processId = $this->uuidFactory->generateUuid4();

        $this->logger->info(sprintf('Try start process %s', $processId->toString()));

        $this->commandBus->dispatch(AuctionStart::create($processId, $event->userId()));
    }
}
