<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

class MessageWithOptions extends Message implements MessageOptionsInterface
{
    use MessageOptionsTrait;

    public function __construct(string $text, string $recipient, array $options)
    {
        parent::__construct($text, $recipient);
        $this->options = $options;
    }
}
