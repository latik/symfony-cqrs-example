<?php

declare(strict_types=1);

namespace App\Presentation\Console;

use App\Application\Command\UserConnect;
use App\Domain\User\UserRepositoryInterface;
use App\Shared\CommandInterface;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserConnectCommand extends Command
{
    protected static $defaultName = 'UserConnect';

    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    protected function configure()
    {
        $this
            ->setDescription('Connect user')
            ->addArgument('id', InputArgument::REQUIRED, 'The user ID');
    }

    public function __construct(
        MessageBusInterface $commandBus,
        DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
        SerializerInterface $serializer,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct(static::$defaultName);
        $this->commandBus = $commandBus;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->userRepository = $userRepository;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $userId = (int)$input->getArgument('id');
        $data = array_merge($input->getArguments(), ['id' => $userId]);

        $io->write(sprintf('id: %s'.PHP_EOL, $userId));

        /** @var UserConnect $command */
        $command = $this->denormalizer->denormalize($data, UserConnect::class);

        $violations = $this->validator->validate($command);

        if (0 !== $violations->count()) {
            $io->write($this->serializer->serialize($violations, JsonEncoder::FORMAT));
            exit;
        }

        $this->commandBus->dispatch($command);

        $user = $this->userRepository->find($userId);
        $io->write($this->serializer->serialize($user, JsonEncoder::FORMAT));
    }
}
