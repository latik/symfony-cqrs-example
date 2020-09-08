<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface MessageSubscriberInterface
{
    public static function getHandledMessages(): iterable;
}
