<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User[]
     */
    private $users = [];

    public function __construct()
    {
        $user = new User();
        $user->id = 42;
        $this->users[42] = $user;
    }

    public function find(int $userId): ?User
    {
        return $this->users[$userId] ?? null;
    }

    public function store(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    public function remove(User $user): void
    {
        unset($this->users[$user->getId()]);
    }

    public function findBy(array $criteria): ?User
    {
        return $this->users[$criteria['id']] ?? null;
    }
}
