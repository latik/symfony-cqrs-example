<?php

declare(strict_types=1);

namespace App\Presentation\Console;

use App\Application\Command\UserConnect;
use App\Domain\User\UserRepositoryInterface;
use Exception;
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
    /**
     * @var string|null The default command name
     */
    protected static $defaultName = 'UserConnect';

    private MessageBusInterface $commandBus;
    private SerializerInterface $serializer;
    private DenormalizerInterface $denormalizer;
    private ValidatorInterface $validator;
    private UserRepositoryInterface $userRepository;

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
     * @throws Exception
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $userId = (int) $input->getArgument('id');
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

        return 0;
    }
}
