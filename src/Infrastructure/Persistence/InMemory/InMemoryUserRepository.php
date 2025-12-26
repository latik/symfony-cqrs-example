<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Shared\UuidInterface;
use App\Domain\User\User;

final class InMemoryUserRepository // implements UserRepositoryInterface
{
    /**
     * @var array<User>
     */
    private array $users = [];

    public function find(UuidInterface $id): ?User
    {
        return $this->users[(string) $id] ?? null;
    }

    public function store(User $user): void
    {
        $this->users[(string) $user->id] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->users[(string) $user->id]);
    }

    /**
     * @return array|User[]
     */
    public function findBy(array $criteria): array
    {
        return [$this->users[$criteria['id']] ?? null];
    }
}
