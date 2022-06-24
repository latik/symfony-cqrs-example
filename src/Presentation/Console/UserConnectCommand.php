<?php

declare(strict_types=1);

namespace App\Presentation\Console;

use App\Application\Command\UserConnect;
use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\DenormalizerInterface;
use App\Domain\Shared\SerializerInterface;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:user-connect',
    description: 'Connect user',
)]
final class UserConnectCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'The user ID');
    }

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly DenormalizerInterface $denormalizer,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly UserRepositoryInterface $userRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = (string) $input->getArgument('id');
        $data = array_merge($input->getArguments(), ['id' => $userId]);

        $output->writeln(sprintf('id: %s'.PHP_EOL, $userId));

        /** @var UserConnect $command */
        $command = $this->denormalizer->denormalize($data, UserConnect::class);

        $violations = $this->validator->validate($command);

        if (0 !== $violations->count()) {
            $output->writeln($this->serializer->serialize($violations, SerializerInterface::JSON_FORMAT));

            return Command::FAILURE;
        }

        $this->commandBus->dispatch($command);

        $user = $this->userRepository->find($userId);
        $output->writeln($this->serializer->serialize($user, SerializerInterface::JSON_FORMAT));

        return Command::SUCCESS;
    }
}
