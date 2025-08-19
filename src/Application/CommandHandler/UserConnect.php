<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\UserConnect as UserConnectCommand;
use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\EventHandlerInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

final readonly class UserConnect implements EventHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventBusInterface $eventBus,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(UserConnectCommand $command): void
    {
        $this->logger->info(\sprintf('Execute UserConnect command %s', $command->id));

        $user = $this->userRepository->find($command->id);
        if (!$user instanceof User) {
            throw new InvalidArgumentException('User not found');
        }

        $user->connect();

        $this->userRepository->store($user);

        $events = $user->releaseEvents();
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
