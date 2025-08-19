<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\UserCreate as UserCreateCommand;
use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\EventHandlerInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

final readonly class UserCreate implements EventHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private EventBusInterface $eventBus,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(UserCreateCommand $command): void
    {
        $this->logger->info(\sprintf('Execute UserCreate command %s', $command->id));

        $userExist = null !== $this->userRepository->find($command->id);
        if ($userExist) {
            throw new InvalidArgumentException('User already exist');
        }

        $user = User::create($command->id);

        $this->userRepository->store($user);

        $events = $user->releaseEvents();
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
