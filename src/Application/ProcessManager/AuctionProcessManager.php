<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use App\Application\Command\AuctionStart;
use App\Domain\Auction\Auction;
use App\Domain\Auction\AuctionRepositoryInterface;
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
    private AuctionRepositoryInterface $auctionRepository;
    private UserRepositoryInterface $userRepository;
    private UuidFactoryInterface $uuidFactory;
    private LoggerInterface $logger;

    public function __construct(
        CommandBusInterface $commandBus,
        AuctionRepositoryInterface $auctionRepository,
        UserRepositoryInterface $userRepository,
        UuidFactoryInterface $uuidFactory,
        LoggerInterface $logger
    ) {
        $this->commandBus = $commandBus;
        $this->auctionRepository = $auctionRepository;
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

        if (null === $user) {
            $this->logger->info(sprintf('User with userId: %s not found', $user->id()));
            return;
        }

        $this->logger->info(sprintf('Found user %s', $user->id()));

        $processId = $this->uuidFactory->generateUuid4();

        $this->logger->info(sprintf('Try start process %s', $processId->toString()));

        $auction = Auction::start($processId, [$user->id()]);

        $this->auctionRepository->save($auction);

        $this->commandBus->dispatch(AuctionStart::create($processId));
    }
}
