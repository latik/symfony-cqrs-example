<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;
use Symfony\Component\Uid\AbstractUid;

final readonly class UserConnected implements EventInterface
{
    public function __construct(public AbstractUid $userId)
    {
    }
}
