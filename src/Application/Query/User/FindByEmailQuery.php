<?php

namespace App\Application\Query\User;

use App\Domain\User\EmailAddress;

final class FindByEmailQuery
{
    /**
     * @var EmailAddress
     */
    public $email;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = EmailAddress::fromString($email);
    }
}
