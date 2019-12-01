<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\UserConnect as UserConnectCommand;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class UserConnect implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private MessageBusInterface $eventBus;
    private LoggerInterface $logger;

    public function __construct(UserRepositoryInterface $userRepository, MessageBusInterface $eventBus, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->eventBus = $eventBus;
        $this->logger = $logger;
    }

    public function __invoke(UserConnectCommand $command): void
    {
        $this->logger->info(sprintf('Execute UserConnect command %s', $command->getId()));

        /** @var User $user */
        $user = $this->userRepository->find($command->getId());
        if (null === $user) {
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
