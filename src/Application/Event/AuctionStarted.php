<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Domain\Shared\EventInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * @property UuidInterface $id
 * @psalm-immutable
 */
final class AuctionStarted implements EventInterface
{
    public UuidInterface $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }
}
