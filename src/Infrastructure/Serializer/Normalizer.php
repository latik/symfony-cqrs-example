<?php

declare(strict_types=1);

namespace App\Infrastructure\Serializer;

use App\Domain\Shared\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;

final class Normalizer implements DenormalizerInterface
{
    private SymfonyDenormalizerInterface $denormalizer;

    public function __construct(SymfonyDenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
