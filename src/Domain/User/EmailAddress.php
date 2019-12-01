<?php

declare(strict_types=1);

namespace App\Domain\User;

use InvalidArgumentException;

final class EmailAddress
{
    private string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromString(string $string): self
    {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid email "%s" provided', $string));
        }

        return new self($string);
    }
}
