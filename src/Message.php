<?php

namespace Wearesho\Delivery;

/**
 * Class Message
 * @package Wearesho\Delivery
 */
class Message implements MessageInterface
{
    use MessageTrait;

    public function __construct(string $text, string $recipient)
    {
        $this->recipient = $recipient;
        $this->text = $text;
    }
}
