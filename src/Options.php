<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

final class Options
{
    public const SENDER_NAME = 'senderName';
    public const CHANNEL = 'channel';
    public const TTL = 'ttl'; // seconds

    public static function get(MessageInterface $message, string $optionKey): mixed
    {
        $options = $message->getOptions();
        return array_key_exists($optionKey, $options) ? $options[$optionKey] : null;
    }
}
