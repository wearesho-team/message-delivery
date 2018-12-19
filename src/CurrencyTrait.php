<?php

namespace Wearesho\Delivery;

/**
 * Trait CurrencyTrait
 * @package Wearesho\Delivery
 */
trait CurrencyTrait
{
    /** @var string */
    protected $currency;

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
