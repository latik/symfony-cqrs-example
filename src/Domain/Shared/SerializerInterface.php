<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface SerializerInterface
{
    public const JSON_FORMAT = 'json';

    public function serialize($data, string $format, array $context = []);
}
