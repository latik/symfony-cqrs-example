<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\EventsRecorderTrait;
use Symfony\Component\Uid\AbstractUid;

class User
{
    use EventsRecorderTrait;

    private const CONNECTED = 'connected';
    private const DISCONNECTED = 'disconnected';

    public string $status = self::DISCONNECTED;

    private function __construct(public AbstractUid $id)
    {
    }

    public static function create(AbstractUid $id): self
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
