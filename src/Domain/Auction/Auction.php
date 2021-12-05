<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\EventsRecorderTrait;
use DateTimeImmutable;
use DomainException;

class Auction
{
    use EventsRecorderTrait;

    private $processId;

    private function __construct($processId, private array $payload, private ?DateTimeImmutable $finishedAt)
    {
        $this->processId = $processId;
    }

    public static function start($processId, array $payload): self
    {
        $instance = new self($processId, $payload, null);
        $instance->record(new AuctionStarted($processId));

        return $instance;
    }

    public function apply(array $payload): self
    {
        if ($this->finishedAt instanceof DateTimeImmutable) {
            throw new DomainException('Can not modify state when its finished');
        }

        return new self($this->processId, [...$this->payload, ...$payload], $this->finishedAt);
    }

    public function done(): self
    {
        return new self($this->processId, $this->payload, new DateTimeImmutable());
    }

    public function has(string $key): bool
    {
        return !empty($this->payload[$key]);
    }

    public function processId()
    {
        return $this->processId;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}
