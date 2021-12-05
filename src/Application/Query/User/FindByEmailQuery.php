<?php

namespace App\Application\Query\User;

use App\Domain\User\EmailAddress;

final class FindByEmailQuery
{
    private readonly EmailAddress $email;

    public function __construct(string $email)
    {
        $this->email = EmailAddress::fromString($email);
    }

    public function email(): EmailAddress
    {
        return $this->email;
    }
}
