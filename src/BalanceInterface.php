<?php

namespace Wearesho\Delivery;

/**
 * Interface BalanceInterface
 * @package Wearesho\Delivery
 */
interface BalanceInterface extends \JsonSerializable
{
    public function getAmount(): float;

    public function getCurrency(): ?string;
}
