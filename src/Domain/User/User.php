<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;

final class User
{
    use EventsRecorderTrait;

    private const CONNECTED = 'connected';
    private const DISCONNECTED = 'disconnected';

    public int $id;

    public string $status = self::DISCONNECTED;

    public function connect(): void
    {
        $this->status = self::CONNECTED;

        $this->record(new UserConnected(['id' => $this->getId()]));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
