<?php

declare(strict_types=1);

namespace App\Domain\Auction;

use App\Domain\Shared\EventsRecorderTrait;
use App\Domain\Shared\UuidInterface;
use DateTimeImmutable;
use DomainException;

class Auction
{
    use EventsRecorderTrait;

    private function __construct(
        private readonly UuidInterface $processId,
        private readonly array $payload,
        private readonly ?DateTimeImmutable $finishedAt = null,
    ) {
    }

    public static function start(UuidInterface $processId, array $payload): self
    {
        $instance = new self(processId: $processId, payload: $payload, finishedAt: null);
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

    public function processId(): UuidInterface
    {
        return $this->processId;
    }

    /**
     * @return mixed[]
     */
    public function payload(): array
    {
        return $this->payload;
    }
}
