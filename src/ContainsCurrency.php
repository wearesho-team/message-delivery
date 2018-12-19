<?php

namespace Wearesho\Delivery;

/**
 * Interface ContainsCurrency
 * @package Wearesho\Delivery
 * @see CurrencyTrait
 */
interface ContainsCurrency
{
    public function getCurrency(): string;
}
