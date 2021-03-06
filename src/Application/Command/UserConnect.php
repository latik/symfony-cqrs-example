<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;

/**
 * @property-read int $id
 * @psalm-immutable
 */
final class UserConnect implements CommandInterface
{
    public int $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->id = (int) ($data['id'] ?? null);
    }

    public function id(): int
    {
        return $this->id;
    }
}
