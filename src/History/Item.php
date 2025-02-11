<?php

declare(strict_types=1);

namespace Wearesho\Delivery\History;

use Carbon\Carbon;
use Wearesho\Delivery;

class Item implements ItemInterface
{
    private readonly \DateTimeInterface $at;
    private readonly \DateTimeInterface $updatedAt;

    public function __construct(
        private readonly int $id,
        private readonly Delivery\ResultInterface $result,
        private readonly string $serviceName,
        ?\DateTimeInterface $at = null,
        ?\DateTimeInterface $updatedAt = null,
    ) {
        $this->at = $at ?? Carbon::now();
        $this->updatedAt = $updatedAt ?? Carbon::now();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function result(): Delivery\ResultInterface
    {
        return $this->result;
    }

    public function serviceName(): string
    {
        return $this->serviceName;
    }

    public function at(): \DateTimeInterface
    {
        return $this->at;
    }

    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
