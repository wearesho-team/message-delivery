<?php

declare(strict_types=1);

namespace Wearesho\Delivery\History;

use Wearesho\Delivery;

interface ItemInterface
{
    public function id(): int;
    public function serviceName(): string;
    public function result(): Delivery\ResultInterface;
    public function at(): \DateTimeInterface;
    public function updatedAt(): \DateTimeInterface;
}
