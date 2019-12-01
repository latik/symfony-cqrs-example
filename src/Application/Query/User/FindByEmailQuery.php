<?php

namespace App\Application\Query\User;

use App\Domain\User\EmailAddress;

final class FindByEmailQuery
{
    private EmailAddress $email;

    public function __construct(string $email)
    {
        $this->email = EmailAddress::fromString($email);
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }
}
