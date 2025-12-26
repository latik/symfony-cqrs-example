<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\UuidInterface;

interface UserRepositoryInterface
{
    public function find(UuidInterface $id): ?User;

    /**
     * @return array<User>
     */
    public function findBy(array $criteria): array;

    public function store(User $user): void;

    public function remove(User $user): void;
}
