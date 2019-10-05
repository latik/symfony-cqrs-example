<?php

declare(strict_types=1);

namespace App\Application\EventHandler;

use App\Application\Event\UserConnected;
use App\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class WriteInLogOnUserConnected implements MessageHandlerInterface
{
    private $userRepository;
    private $serializer;
    private $logger;

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
        $user = $this->userRepository->find($event->getId());

        $userJson = $this->serializer->serialize($user, 'json');

        $this->logger->info(sprintf('User connected: %s', $userJson));
    }
}
