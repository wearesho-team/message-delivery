<?php

namespace Wearesho\Delivery;

use Wearesho\Delivery;

/**
 * Interface ServiceInterface
 * @package Wearesho\Delivery
 */
interface ServiceInterface
{
    /**
     * @param Delivery\MessageInterface $message
     * @throws Delivery\Exception
     */
    public function send(Delivery\MessageInterface $message): void;
}
