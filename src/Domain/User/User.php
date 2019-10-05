<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Application\Event\UserConnected;
use App\Shared\EventsRecorderTrait;

final class User
{
    use EventsRecorderTrait;

    private const CONNECTED = 'connected';
    private const DISCONNECTED = 'disconnected';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $status = self::DISCONNECTED;

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
