<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\User\User;

final class InMemoryUserRepository
{
    /**
     * @var array<User>
     */
    private array $users = [];

    public function find(int $userId): ?User
    {
        return $this->users[$userId] ?? null;
    }

    public function store(User $user): void
    {
        $this->users[$user->id()] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->users[$user->id()]);
    }

    public function findBy(array $criteria): ?User
    {
        return $this->users[$criteria['id']] ?? null;
    }
}
