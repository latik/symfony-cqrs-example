<?php

namespace App\Domain\Shared;

interface DenormalizerInterface
{
    public function denormalize($data, string $type, ?string $format = null, array $context = []);
}
