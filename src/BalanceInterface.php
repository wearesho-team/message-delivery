<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

interface BalanceInterface
{
    public function getAmount(): float;

    public function getCurrency(): ?string;
}
