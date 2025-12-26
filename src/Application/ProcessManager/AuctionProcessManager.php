<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use App\Application\Command\AuctionStart;
use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\EventInterface;
use App\Domain\Shared\MessageSubscriberInterface;
use App\Domain\Shared\UuidFactoryInterface;
use App\Domain\User\UserConnected;
use Psr\Log\LoggerInterface;

final readonly class AuctionProcessManager implements MessageSubscriberInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private UuidFactoryInterface $uuidFactory,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(EventInterface $event): void
    {
        foreach (self::getHandledMessages() as $className => $config) {
            if ($className === $event::class) {
                self::{$config['method']}($event);
            }
        }
    }

    /**
     * @return \Iterator<array<string, string>>
     */
    #[\Override]
    public static function getHandledMessages(): \Iterator
    {
        yield UserConnected::class => ['method' => 'handleThatUserConnected', 'bus' => 'event.bus'];
    }

    public function handleThatUserConnected(UserConnected $event): void
    {
        $processId = $this->uuidFactory->generate();

        $this->logger->info(\sprintf('Try start process %s', $processId));

        $this->commandBus->dispatch(AuctionStart::create($processId, $event->userId));
    }
}
