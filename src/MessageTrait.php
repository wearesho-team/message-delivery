<?php

namespace Wearesho\Delivery;

/**
 * Trait MessageTrait
 * @package Wearesho\Delivery
 */
trait MessageTrait
{
    /** @var  string */
    protected $recipient;

    /** @var  string */
    protected $text;

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
