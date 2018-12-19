<?php

namespace Wearesho\Delivery;

/**
 * Interface SupportBalanceMethod
 * @package Wearesho\Delivery
 */
interface SupportBalanceMethod
{
    public function balance(): BalanceInterface;
}
