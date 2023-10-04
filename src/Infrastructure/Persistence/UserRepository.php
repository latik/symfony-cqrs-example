<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\Doctrine\Repository\SqlUserRepository as Repository;
use Symfony\Component\Uid\AbstractUid;

final readonly class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Repository $doctrineRepository)
    {
    }

    public function find(AbstractUid $id): ?User
    {
        return $this->doctrineRepository->find($id);
    }

    /**
     * @return User[]
     */
    public function findBy(array $criteria): array
    {
        return $this->doctrineRepository->findBy($criteria);
    }

    public function store(User $user): void
    {
        $this->doctrineRepository->persist($user);
    }

    public function remove(User $user): void
    {
        $this->doctrineRepository->remove($user);
    }
}
