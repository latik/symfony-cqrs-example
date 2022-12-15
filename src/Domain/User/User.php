<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;

class User
{
    use EventsRecorderTrait;

    private const CONNECTED = 'connected';
    private const DISCONNECTED = 'disconnected';

    public string $status = self::DISCONNECTED;

    private function __construct(public readonly int $id)
    {
    }

    public static function create(int $id): self
    {
        $instance = new self(id: $id);

        $instance->record(new UserCreated(userId: $instance->id));

        return $instance;
    }

    public function connect(): void
    {
        $this->status = self::CONNECTED;

        $this->record(new UserConnected(userId: $this->id));
    }

    public function status(): string
    {
        return $this->status;
    }
}
