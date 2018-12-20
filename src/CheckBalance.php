<?php

namespace Wearesho\Delivery;

/**
 * Interface CheckBalance
 * @package Wearesho\Delivery
 */
interface CheckBalance
{
    public function balance(): BalanceInterface;
}
