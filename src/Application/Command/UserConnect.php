<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;

/**
 * @psalm-immutable
 */
final class UserConnect implements CommandInterface
{
    public readonly string $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->id = (string) ($data['id'] ?? null);
    }
}
