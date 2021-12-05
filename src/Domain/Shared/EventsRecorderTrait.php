<?php

declare(strict_types=1);

namespace App\Domain\Shared;

trait EventsRecorderTrait
{
    /**
     * @var EventInterface[]
     */
    private array $events = [];

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    private function record(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}
