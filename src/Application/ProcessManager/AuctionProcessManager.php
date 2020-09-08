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
    private CommandBusInterface $commandBus;
    private StateRepository $stateRepository;
    private UserRepositoryInterface $userRepository;
    private UuidFactoryInterface $uuidFactory;
    private LoggerInterface $logger;

    public function __construct(
        CommandBusInterface $commandBus,
        StateRepository $stateRepository,
        UserRepositoryInterface $userRepository,
        UuidFactoryInterface $uuidFactory,
        LoggerInterface $logger
    ) {
        $this->commandBus = $commandBus;
        $this->stateRepository = $stateRepository;
        $this->userRepository = $userRepository;
        $this->uuidFactory = $uuidFactory;
        $this->logger = $logger;
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
        $user = $this->userRepository->find($event->userId());

        $state = State::start($this->uuidFactory->generateUuid4(), [$user->id()]);

        $this->stateRepository->save($state);

        $this->commandBus->dispatch(AuctionStart::create($this->uuidFactory->generateUuid4()));
    }
}
