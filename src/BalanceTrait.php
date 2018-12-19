<?php

namespace Wearesho\Delivery;

/**
 * Trait BalanceTrait
 * @package Wearesho\Delivery
 */
trait BalanceTrait
{
    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }
}
