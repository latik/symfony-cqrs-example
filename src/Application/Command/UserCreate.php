<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use Symfony\Component\Uid\AbstractUid;

final readonly class UserCreate implements CommandInterface
{
    public function __construct(public AbstractUid $id)
    {
    }
}
