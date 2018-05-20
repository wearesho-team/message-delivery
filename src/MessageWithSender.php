<?php

namespace Wearesho\Delivery;

/**
 * Class MessageWithSender
 * @package Wearesho\Delivery
 */
class MessageWithSender extends Message implements ContainsSenderName
{
    use SenderNameTrait;

    public function __construct(string $text, string $recipient, string $senderName)
    {
        parent::__construct($text, $recipient);
        $this->senderName = $senderName;
    }
}
