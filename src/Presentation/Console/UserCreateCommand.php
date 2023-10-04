<?php

declare(strict_types=1);

namespace App\Presentation\Console;

use App\Application\Command\UserCreate;
use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\SerializerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Factory\UuidFactory;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:user-create',
    description: 'Create user',
)]
final class UserCreateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::OPTIONAL, 'The user ID');
    }

    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly ValidatorInterface $validator,
        private readonly SerializerInterface $serializer,
        private readonly UuidFactory $uuidFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = $input->hasArgument('id')
            ? Uuid::fromString((string) $input->getArgument('id'))
            : $this->uuidFactory->create();

        $output->writeln(\sprintf('id: %s'.PHP_EOL, $userId));

        $command = new UserCreate($userId);

        $violations = $this->validator->validate($command);

        if (0 !== $violations->count()) {
            $output->writeln($this->serializer->serialize($violations, SerializerInterface::JSON_FORMAT));

            return Command::FAILURE;
        }

        $this->commandBus->dispatch($command);

        return Command::SUCCESS;
    }
}
