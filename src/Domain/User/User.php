<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;

class User
{
    use EventsRecorderTrait;

    private const string CONNECTED = 'connected';
    private const string DISCONNECTED = 'disconnected';

    private(set) string $status = self::DISCONNECTED {
        get => $this->status;
    }

    private function __construct(public readonly UserId $id)
    {
    }

    public static function create(UserId $id): self
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
}
