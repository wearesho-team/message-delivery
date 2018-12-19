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

    public function getAmount(): float
    {
        return $this->amount;
    }
}
