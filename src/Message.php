<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

class Message implements MessageInterface
{
    public function __construct(
        private readonly string $text,
        private readonly string $recipient,
        private readonly array $options = []
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
