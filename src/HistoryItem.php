<?php

namespace Wearesho\Delivery;

/**
 * Class HistoryItem
 * @package Wearesho\Delivery
 */
class HistoryItem implements HistoryItemInterface, ContainsSenderName
{
    use MessageTrait, SenderNameTrait;

    /** @var \DateTimeInterface */
    protected $date;

    /** @var string */
    protected $sender;

    /** @var bool */
    protected $sent;

    public function __construct(
        MessageInterface $message,
        string $sender,
        bool $sent,
        \DateTimeInterface $date = null
    ) {
        $this->text = $message->getText();
        $this->recipient = $message->getRecipient();

        $this->sender = $sender;
        $this->sent = $sent;

        $this->date = $date ?? new \DateTime;

        $this->senderName = $message instanceof ContainsSenderName
            ? $message->getSenderName()
            : '';
    }

    public function isSent(): bool
    {
        return $this->sent;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getSentAt(): \DateTimeInterface
    {
        return $this->date;
    }
}
