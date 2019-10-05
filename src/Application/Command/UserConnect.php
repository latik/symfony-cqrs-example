<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Shared\CommandInterface;

final class UserConnect implements CommandInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->id = (int) ($data['id'] ?? null);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
