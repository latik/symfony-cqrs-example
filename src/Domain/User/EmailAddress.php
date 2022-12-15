<?php

declare(strict_types=1);

namespace App\Domain\User;

use InvalidArgumentException;
use Stringable;

final readonly class EmailAddress implements Stringable
{
    private function __construct(private string $email)
    {
    }

    public static function fromString(string $string): self
    {
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid email "%s" provided', $string));
        }

        return new self($string);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
