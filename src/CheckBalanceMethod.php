<?php

namespace Wearesho\Delivery;

/**
 * Interface CheckBalanceMethod
 * @package Wearesho\Delivery
 */
interface CheckBalanceMethod
{
    public function balance(): BalanceInterface;
}
