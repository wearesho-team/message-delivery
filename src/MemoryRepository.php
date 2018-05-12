<?php

namespace Wearesho\Delivery;

/**
 * Class MemoryRepository
 * Created for test purposes
 *
 * @package Wearesho\Delivery
 */
class MemoryRepository implements RepositoryInterface
{
    /** @var array[] */
    protected $history = [];

    /**
     * @inheritdoc
     */
    public function push(MessageInterface $message, string $sender, bool $sent): void
    {
        $this->history[] = [
            'message' => $message,
            'sender' => $sender,
            'sent' => $sent,
        ];
    }

    /**
     * @inheritdoc
     */
    public function isSent(MessageInterface $message): ?bool
    {
        $historyItem = $this->getHistoryItem($message);

        return $historyItem ? $historyItem['sent'] : null;
    }

    /**
     * @inheritdoc
     */
    public function getSender(MessageInterface $message): ?string
    {
        $historyItem = $this->getHistoryItem($message);

        return $historyItem ? $historyItem['sender'] : null;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function getHistoryItem(MessageInterface $message): ?array
    {
        foreach ($this->history as $item) {
            /** @var MessageInterface $itemMessage */
            $itemMessage = $item['message'];
            $isMatch = $itemMessage->getRecipient() === $message->getRecipient()
                && $itemMessage->getText() === $message->getText();

            if ($isMatch) {
                return $item;
            }
        }

        return null;
    }

    public function flush(): void
    {
        $this->history = [];
    }
}
