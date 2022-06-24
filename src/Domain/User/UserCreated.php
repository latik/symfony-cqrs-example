<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;
use App\Domain\Shared\UuidInterface;

final class UserCreated implements EventInterface
{
    public readonly UuidInterface $userId;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->userId = $data['id'] ?? null;
    }
}
