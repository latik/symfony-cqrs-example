<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface UuidFactoryInterface
{
    public function generateUuid4(): UuidInterface;
}
