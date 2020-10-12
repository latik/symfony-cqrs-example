<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;

class User
{
    use EventsRecorderTrait;

    private const CONNECTED = 'connected';
    private const DISCONNECTED = 'disconnected';

    public int $id;

    public string $status = self::DISCONNECTED;

    public static function create(int $id): self
    {
        $instance = new self();
        $instance->id = $id;
        $instance->record(new UserCreated(['id' => $instance->id()]));

        return $instance;
    }

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
