<?php

namespace Wearesho\Delivery;

/**
 * Class Balance
 * @package Wearesho\Delivery
 */
class Balance implements BalanceInterface
{
    use BalanceTrait;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function __toString(): string
    {
        return number_format($this->getAmount(), 2);
    }
}
