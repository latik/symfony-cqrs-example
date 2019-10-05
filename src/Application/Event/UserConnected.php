<?php

declare(strict_types=1);

namespace App\Application\Event;

use App\Shared\EventInterface;

final class UserConnected implements EventInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data)
    {
        $this->id = (int) ($data['id'] ?? null);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
