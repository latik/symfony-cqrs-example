<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Shared\CommandInterface;
use App\Domain\Shared\UuidInterface;

/**
 * @property UuidInterface $id
 * @psalm-immutable
 */
final class AuctionStart implements CommandInterface
{
    public UuidInterface $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->id = ($data['id'] ?? null);
    }

    public static function create(UuidInterface $uuid4)
    {
        return new self(['id' => $uuid4]);
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }
}
