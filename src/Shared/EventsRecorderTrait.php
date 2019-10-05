<?php

declare(strict_types=1);

namespace App\Shared;

trait EventsRecorderTrait
{
    /**
     * @var EventInterface[]
     */
    private $events = [];

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        [$events, $this->events] = [$this->events, []];

        return $events;
    }

    private function record(EventInterface $event): void
    {
        $this->events[] = $event;
    }
}
