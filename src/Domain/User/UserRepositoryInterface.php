<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;

    public function findBy(array $criteria): ?User;

    public function store(User $user): void;

    public function remove(User $user): void;
}
