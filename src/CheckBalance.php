<?php declare(strict_types=1);

namespace Wearesho\Delivery;

interface CheckBalance
{
    public function balance(): BalanceInterface;
}
