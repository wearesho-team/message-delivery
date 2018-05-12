<?php

namespace Wearesho\Delivery;

/**
 * Interface HistoryItemInterface
 * @package Wearesho\Delivery
 */
interface HistoryItemInterface extends MessageInterface
{
    public function isSent(): bool;

    public function getSender(): string;

    public function getSentAt(): \DateTimeInterface;
}
