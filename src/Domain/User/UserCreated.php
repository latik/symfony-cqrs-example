<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;
use App\Domain\Shared\UuidInterface;
use Symfony\Component\Uid\AbstractUid;

final readonly class UserCreated implements EventInterface
{
    public function __construct(public AbstractUid $userId)
    {
    }
}
