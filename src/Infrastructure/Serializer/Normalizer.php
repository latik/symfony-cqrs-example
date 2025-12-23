<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use App\Domain\Shared\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;

final readonly class Normalizer implements DenormalizerInterface
{
    public function __construct(private SymfonyDenormalizerInterface $denormalizer)
    {
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = []): mixed
    {
        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
