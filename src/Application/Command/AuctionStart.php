<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Shared\CommandInterface;
use Ramsey\Uuid\UuidInterface;

final class AuctionStart implements CommandInterface
{
    /**
     * @var UuidInterface
     */
    public $id;

    /**
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->id = ($data['id'] ?? null);
    }

    public static function create(UuidInterface $uuid4)
    {
        return new self(['id' => $uuid4]);
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
