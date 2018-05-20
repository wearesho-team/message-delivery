<?php

namespace Wearesho\Delivery;

/**
 * Trait SenderNameTrait
 * @package Wearesho\Delivery
 * @see ContainsSenderName
 */
trait SenderNameTrait
{
    /** @var string */
    protected $senderName;

    public function getSenderName(): string
    {
        return $this->senderName;
    }
}
