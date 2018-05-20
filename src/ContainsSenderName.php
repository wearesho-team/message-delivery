<?php

namespace Wearesho\Delivery;

/**
 * Interface ContainsSenderName
 * @package Wearesho\Delivery
 * @see SenderNameTrait
 */
interface ContainsSenderName
{
    public function getSenderName(): string;
}
