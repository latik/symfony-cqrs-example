<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;

/**
 * @psalm-immutable
 */
final class UserCreate implements CommandInterface
{
    public readonly string $id;

    /**
     * @param array{id:string} $data
     */
    public function __construct(array $data = [])
    {
        $this->id = (string) ($data['id'] ?? null);
    }
}
