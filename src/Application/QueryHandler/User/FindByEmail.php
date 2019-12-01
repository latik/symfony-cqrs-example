<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\FindByEmailQuery;
use App\Domain\Shared\QueryHandlerInterface;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class FindByEmail implements QueryHandlerInterface
{
    private UserRepositoryInterface $repository;
    private SerializerInterface $serializer;

    public function __construct(UserRepositoryInterface $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;
        $this->serializer = $serializer;
    }

    public function __invoke(FindByEmailQuery $query)
    {
        $criteria = ['email' => $query->getEmail()];
        $userView = $this->repository->findBy($criteria);

        return $this->serializer->serialize($userView, JsonEncoder::FORMAT);
    }
}
