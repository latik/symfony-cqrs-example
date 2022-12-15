<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;

final readonly class UserCreate implements CommandInterface
{
    public function __construct(public int $id)
    {
    }
}
