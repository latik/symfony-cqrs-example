<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Domain\Shared\EventHandlerInterface;
use App\Domain\Shared\SerializerInterface;
use App\Domain\User\UserConnected;
use App\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

final class WriteInLogOnUserConnected implements EventHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private SerializerInterface $serializer;
    private LoggerInterface $logger;

    public function __construct(
        UserRepositoryInterface $userRepository,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(UserConnected $event): void
    {
        $user = $this->userRepository->find($event->userId());

        $userJson = $this->serializer->serialize($user, SerializerInterface::JSON_FORMAT);

        $this->logger->info(sprintf('User connected: %s', $userJson));
    }
}
