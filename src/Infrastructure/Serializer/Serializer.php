<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use App\Domain\Shared\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

final readonly class Serializer implements SerializerInterface
{
    public function __construct(private SymfonySerializerInterface $serializer)
    {
    }

    public function serialize($data, string $format, array $context = []): string
    {
        return $this->serializer->serialize($data, $format, $context);
    }

    public function deserialize(mixed $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
