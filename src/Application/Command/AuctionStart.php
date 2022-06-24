<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;

/**
 * @psalm-immutable
 */
final class AuctionStart implements CommandInterface
{
    public readonly UuidInterface $id;

    public readonly int $userId;

    /**
     * @param array{id:UuidInterface, userId:int} $data
     */
    private function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->userId = $data['userId'] ?? null;
    }

    public static function create(UuidInterface $uuid4, int $userId): self
    {
        return new self(['id' => $uuid4, 'userId' => $userId]);
    }
}
