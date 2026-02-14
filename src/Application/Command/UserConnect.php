<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;
use App\Domain\User\UserId;

final readonly class UserConnect implements CommandInterface
{
    public function __construct(public UserId $id)
    {
    }
}
