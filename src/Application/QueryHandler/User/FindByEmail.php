<?php

declare(strict_types=1);

namespace App\Application\QueryHandler\User;

use App\Application\Query\User\FindByEmailQuery;
use App\Domain\User\UserRepositoryInterface;
use App\Shared\QueryHandlerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class FindByEmail implements QueryHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(UserRepositoryInterface $repository, SerializerInterface $serializer)
    {
        $this->repository = $repository;

        $this->serializer = $serializer;
    }

    public function __invoke(FindByEmailQuery $query)
    {
        $criteria = ['email' => $query->email];
        $userView = $this->repository->findBy($criteria);

        return $this->serializer->serialize($userView, JsonEncoder::FORMAT);
    }
}
