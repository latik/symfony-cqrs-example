<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use App\Application\Command\AuctionStart;
use App\Application\Event\UserConnected;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class AuctionProcessManager implements MessageSubscriberInterface
{
    private $commandBus;
    private $stateRepository;
    private $userRepository;

    public function __construct(
        MessageBusInterface $commandBus,
        StateRepository $stateRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->commandBus = $commandBus;
        $this->stateRepository = $stateRepository;
        $this->userRepository = $userRepository;
    }

    public static function getHandledMessages(): iterable
    {
        yield UserConnected::class => ['method' => 'handleThatUserConnected', 'bus' => 'event.bus'];
    }

    public function handleThatUserConnected(UserConnected $event): void
    {
        /** @var User $user */
        $user = $this->userRepository->find($event->getId());

        $state = State::start(Uuid::uuid4(), [$user->getId()]);

        $this->stateRepository->save($state);

        $this->commandBus->dispatch(AuctionStart::create(Uuid::uuid4()));
    }
}
