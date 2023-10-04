<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Uid\AbstractUid;

final class InMemoryUserRepository // implements UserRepositoryInterface
{
    /**
     * @var array<User>
     */
    private array $users = [];

    public function find(AbstractUid $id): ?User
    {
        return $this->users[$id->toString()] ?? null;
    }

    public function store(User $user): void
    {
        $this->users[$user->id->toString()] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->users[$user->id->toString()]);
    }

    /**
     * @return array|User[]
     */
    public function findBy(array $criteria): array
    {
        return [$this->users[$criteria['id']] ?? null];
    }
}
