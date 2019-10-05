<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Shared\EventInterface;
use Ramsey\Uuid\UuidInterface;

final class AuctionStarted implements EventInterface
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
