<?php

declare(strict_types=1);

namespace App\Presentation\Console;

use App\Application\Command\UserCreate;
use App\Domain\Shared\CommandBusInterface;
use App\Domain\Shared\DenormalizerInterface;
use App\Domain\Shared\SerializerInterface;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserCreateCommand extends Command
{
    /**
     * @var string|null The default command name
     */
    protected static $defaultName = 'UserCreate';

    protected function configure(): void
    {
        $this
            ->setDescription('Create user')
            ->addArgument('id', InputArgument::REQUIRED, 'The user ID');
    }

    public function __construct(
        private CommandBusInterface $commandBus,
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) {
        parent::__construct(static::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userId = (int) $input->getArgument('id');
        $data = array_merge($input->getArguments(), ['id' => $userId]);

        $output->writeln(sprintf('id: %s'.PHP_EOL, $userId));

        /** @var UserCreate $command */
        $command = $this->denormalizer->denormalize($data, UserCreate::class);

        $violations = $this->validator->validate($command);

        if (0 !== $violations->count()) {
            $output->writeln($this->serializer->serialize($violations, SerializerInterface::JSON_FORMAT));

            return Command::FAILURE;
        }

        $this->commandBus->dispatch($command);

        return Command::SUCCESS;
    }
}
