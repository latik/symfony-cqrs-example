<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;

final class UserConnected implements EventInterface
{
    public int $userId;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->userId = (int) ($data['id'] ?? null);
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
