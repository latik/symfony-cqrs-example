<?php

declare(strict_types=1);

namespace App\Application\ProcessManager;

use Ramsey\Uuid\UuidInterface;

final class State
{
    /** @var UuidInterface */
    private $processId;

    /** @var array */
    private $payload = [];

    /** @var ?\DateTimeImmutable */
    private $finishedAt;

    private function __construct(UuidInterface $processId, array $payload, ?\DateTimeImmutable $finishedAt)
    {
        $this->payload = $payload;
        $this->processId = $processId;
        $this->finishedAt = $finishedAt;
    }

    public static function start(UuidInterface $processId, array $payload): self
    {
        return new self($processId, $payload, null);
    }

    public function apply(array $payload): self
    {
        if ($this->finishedAt instanceof \DateTimeImmutable) {
            throw new \DomainException('Can not modify state when its finished');
        }

        return new self($this->processId, array_merge($this->payload, $payload), $this->finishedAt);
    }

    public function done(): self
    {
        return new self($this->processId, $this->payload, new \DateTimeImmutable());
    }

    public function has(string $key): bool
    {
        return !empty($this->payload[$key]);
    }

    public function processId(): UuidInterface
    {
        return $this->processId;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}
