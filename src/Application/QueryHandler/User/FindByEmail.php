<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\FindByEmailQuery;
use App\Domain\Shared\QueryHandlerInterface;
use App\Domain\Shared\SerializerInterface;
use App\Domain\User\UserRepositoryInterface;

final class FindByEmail implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $repository, private readonly SerializerInterface $serializer)
    {
    }

    public function __invoke(FindByEmailQuery $query)
    {
        $criteria = ['email' => $query->email()];
        $userView = $this->repository->findBy($criteria);

        return $this->serializer->serialize($userView, SerializerInterface::JSON_FORMAT);
    }
}
