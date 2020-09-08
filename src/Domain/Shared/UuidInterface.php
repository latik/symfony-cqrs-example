<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface UuidInterface
{
    public function toString(): string;
}