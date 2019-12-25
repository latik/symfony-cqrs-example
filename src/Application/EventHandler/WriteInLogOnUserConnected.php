<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Domain\User\UserConnected;
use App\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class WriteInLogOnUserConnected implements MessageHandlerInterface
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
        $user = $this->userRepository->find($event->id());

        $userJson = $this->serializer->serialize($user, 'json');

        $this->logger->info(sprintf('User connected: %s', $userJson));
    }
}
