<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;

final readonly class UserConnected implements EventInterface
{
    public function __construct(public UserId $userId)
    {
    }
}
