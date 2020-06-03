<?php

namespace Wearesho\Delivery\Message;

interface Recipient
{
    public function getRecipient(): string;
}
