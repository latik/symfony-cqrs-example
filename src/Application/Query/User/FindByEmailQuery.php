<?php

namespace App\Application\Query\User;

use App\Domain\User\EmailAddress;

final readonly class FindByEmailQuery
{
    public EmailAddress $email;

    public function __construct(string $email)
    {
        $this->email = EmailAddress::fromString($email);
    }
}
