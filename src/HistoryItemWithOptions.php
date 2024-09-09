<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

class HistoryItemWithOptions extends HistoryItem implements HistoryItemWithOptionsInterface
{
    private ?array $options;

    public function __construct(
        MessageInterface $message,
        string $sender,
        bool $sent,
        \DateTimeInterface $date = null,
        ?array $options = null
    ) {
        parent::__construct($message, $sender, $sent, $date);
        $this->options = $options;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }
}
