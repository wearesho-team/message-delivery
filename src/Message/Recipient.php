<?php declare(strict_types=1);

namespace Wearesho\Delivery\Message;

interface Recipient
{
    public function getRecipient(): string;
}
