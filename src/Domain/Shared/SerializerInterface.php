<?php

declare(strict_types=1);

namespace App\Domain\Shared;

interface SerializerInterface
{
    final public const string JSON_FORMAT = 'json';

    public function serialize($data, string $format, array $context = []);
}
