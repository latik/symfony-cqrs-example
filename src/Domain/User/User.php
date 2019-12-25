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

        $this->record(new UserConnected(['id' => $this->id()]));
    }

    public function id(): int
    {
        return $this->id;
    }

    public function status(): string
    {
        return $this->status;
    }
}
