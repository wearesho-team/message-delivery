<?php

namespace Wearesho\Delivery;

/**
 * Interface MessageInterface
 * @package Wearesho\Delivery
 */
interface MessageInterface
{
    public function getRecipient(): string;

    public function getText(): string;
}
