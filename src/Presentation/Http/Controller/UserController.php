<?php

declare(strict_types=1);

namespace App\Presentation\Http\Controller;

use App\Application\Command\UserConnect;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
        private readonly DenormalizerInterface $denormalizer,
        private readonly ValidatorInterface $validator,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route(path: '/', name: 'connect')]
    public function connect() : JsonResponse
    {
        $data = ['id' => 42];

        /** @var UserConnect $command */
        $command = $this->denormalizer->denormalize($data, UserConnect::class);

        $violations = $this->validator->validate($command);
        if (0 !== $violations->count()) {
            return $this->json(['msg' => 'Not valid id'], 400);
        }

        $this->logger->info(sprintf('User %s try to connect', $command->id));

        $this->commandBus->dispatch($command);

        return $this->json([
            'msg' => 'User connected',
        ]);
    }
}
