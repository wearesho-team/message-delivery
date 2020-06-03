<?php

namespace Wearesho\Delivery\Message;

trait RecipientTrait
{
    protected string $recipient;

    public function getRecipient(): string
    {
        return $this->recipient;
    }
}
