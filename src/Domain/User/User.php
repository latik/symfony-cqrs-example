<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;
use App\Domain\Shared\UuidInterface;
class User
{
    use EventsRecorderTrait;

    private const string CONNECTED = 'connected';
    private const string DISCONNECTED = 'disconnected';

    private(set) string $status = self::DISCONNECTED {
        get => $this->status;
    }

    private function __construct(public readonly UuidInterface $id)
    {
    }

    public static function create(UuidInterface $id): self
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
