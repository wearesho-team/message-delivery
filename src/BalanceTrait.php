<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

trait BalanceTrait
{
    protected float $amount;

    protected ?string $currency = null;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }
}
