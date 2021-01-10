<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;

/**
 * @property-read UuidInterface $id
 * @property-read int $userId
 * @psalm-immutable
 */
final class AuctionStart implements CommandInterface
{
    public UuidInterface $id;

    public int $userId;

    /**
     * @param mixed[] $data
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

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
