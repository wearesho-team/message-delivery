<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

interface MessageOptionsInterface
{
    /**
     * Should replace
     * @see MessageWithSender
     */
    public const OPTION_SENDER_NAME = 'senderName';
    public const OPTION_CHANNEL = 'channel';

    public function getOptions(): array;
}
