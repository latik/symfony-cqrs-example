<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventInterface;

final class UserConnected implements EventInterface
{
    public int $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? null);
    }

    public function id(): int
    {
        return $this->id;
    }
}
