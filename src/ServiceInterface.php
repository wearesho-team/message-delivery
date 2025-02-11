<?php

namespace Wearesho\Delivery;

use Wearesho\Delivery;

/**
 * Interface ServiceInterface
 * @package Wearesho\Delivery
 */
interface ServiceInterface
{
    public function name(): string;

    public function balance(): BalanceInterface;

    /**
     * @param Delivery\MessageInterface $message
     * @throws Delivery\Exception
     */
    public function send(Delivery\MessageInterface $message): ResultInterface;
}
