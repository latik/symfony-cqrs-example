<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Application\Command\UserCreate as UserCreateCommand;
use App\Application\CommandHandler\UserCreate as UserCreateHandler;
use App\Domain\Shared\EventBusInterface;
use App\Domain\Shared\UuidFactoryInterface;
use App\Domain\User\UserId;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\User;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group integration
 * @covers \App\Application\CommandHandler\UserCreate
 */
final class UserCreateHandlerTest extends KernelTestCase
{
    private static $entityManager;
    private ?string $lastUserId = null;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        self::$entityManager = $container->get('doctrine')->getManager();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $conn = self::$entityManager->getConnection();
        $platform = $conn->getDatabasePlatform();
        if (method_exists($platform, 'registerDoctrineTypeMapping')) {
            $platform->registerDoctrineTypeMapping('array', 'text');
            $platform->registerDoctrineTypeMapping('json', 'text');
            $platform->registerDoctrineTypeMapping('uuid', 'text');
        }

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
            $conn = self::$entityManager->getConnection();
            $conn->executeStatement('DELETE FROM users WHERE id = :id', ['id' => $this->lastUserId]);
            $this->lastUserId = null;
        }

        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
        if (null !== self::$entityManager) {
            self::$entityManager->close();
            self::$entityManager = null;
        }
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

        // Use real repository wired in the container; fetch handler which should be autowired with real repo
        /** @var UserCreateHandler $handler */
        $handler = $container->get(UserCreateHandler::class);
        $handler->__invoke($command);

        // Verify raw DB row exists
        $conn = self::$entityManager->getConnection();
        $row = $conn->fetchAssociative('SELECT * FROM users WHERE id = :id', ['id' => (string) $userId]);

        $this->assertIsArray($row);
        $this->assertEquals((string) $userId, $row['id']);
    }
}

