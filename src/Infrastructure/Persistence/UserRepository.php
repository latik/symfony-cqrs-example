<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\InMemory\InMemoryUserRepository;

final class UserRepository implements UserRepositoryInterface
{
    private InMemoryUserRepository $repository;

    public function __construct(InMemoryUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function findBy(array $criteria): ?User
    {
        return $this->repository->findBy($criteria);
    }

    public function store(User $user): void
    {
        $this->repository->store($user);
    }

    public function remove(User $user): void
    {
        $this->repository->remove($user);
    }
}
