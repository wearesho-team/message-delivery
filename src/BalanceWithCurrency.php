<?php

namespace Wearesho\Delivery;

/**
 * Class BalanceWithCurrency
 * @package Wearesho\Delivery
 */
class BalanceWithCurrency extends Balance implements ContainsCurrency
{
    use CurrencyTrait;

    public function __construct(float $amount, string $currency)
    {
        $this->currency = $currency;

        parent::__construct($amount);
    }

    public function __toString(): string
    {
        $amount = parent::__toString();

        return  "{$amount} {$this->getCurrency()}";
    }
}
