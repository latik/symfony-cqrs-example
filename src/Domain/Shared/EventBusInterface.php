<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface EventBusInterface
{
    public function dispatch(EventInterface $event): void;
}
