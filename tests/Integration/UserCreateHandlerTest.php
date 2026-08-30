<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Application\Command\UserCreate as UserCreateCommand;
use App\Application\CommandHandler\UserCreate as UserCreateHandler;
use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\UuidFactoryInterface;
use App\Domain\User\UserId;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 * @covers \App\Application\CommandHandler\UserCreate
 */
final class UserCreateHandlerTest extends KernelTestCase
{
    private ?string $lastUserId = null;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure EventBus and Logger are present as simple stubs to avoid side effects
        $container = static::getContainer();

        $testEventBus = new class() implements EventBusInterface {
            public function dispatch(object $event): void
            {
                // no-op
            }
        };

        $testLogger = new \Psr\Log\NullLogger();

        // Register in container (test container supports set)
        $container->set(EventBusInterface::class, $testEventBus);
        $container->set(LoggerInterface::class, $testLogger);
    }

    protected function tearDown(): void
    {
        // Clean up created test row if exists
        if ($this->lastUserId !== null) {
            $conn = static::getContainer()->get('doctrine')->getManager()->getConnection();
            $conn->executeStatement('DELETE FROM users WHERE id = :id', ['id' => $this->lastUserId]);
            $this->lastUserId = null;
        }

        parent::tearDown();
    }

    public function test_it_persists_user_to_database(): void
    {
        $container = static::getContainer();

        /** @var UuidFactoryInterface $uuidFactory */
        $uuidFactory = $container->get(UuidFactoryInterface::class);

        $uuid = $uuidFactory->generate();

        $userId = UserId::create($uuid);
        $this->lastUserId = (string) $userId;

        $command = new UserCreateCommand($userId);

        /** @var UserCreateHandler $handler */
        $handler = $container->get(UserCreateHandler::class);
        $handler->__invoke($command);

        // Verify raw DB row exists
        $conn = static::getContainer()->get('doctrine')->getManager()->getConnection();
        $row = $conn->fetchAssociative('SELECT * FROM users WHERE id = :id', ['id' => (string) $userId]);

        self::assertIsArray($row);
        self::assertSame((string) $userId, $row['id']);
    }
}

