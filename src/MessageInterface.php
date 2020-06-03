<?php

namespace Wearesho\Delivery;

interface MessageInterface extends Message\Text, Message\Recipient
{
    public function getRecipient(): string;
}
