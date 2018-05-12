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
    /** @var HistoryItem[] */
    protected $history = [];

    /**
     * @inheritdoc
     */
    public function push(MessageInterface $message, string $sender, bool $sent): void
    {
        $this->history[] = new HistoryItem($message, $sender, $sent);
    }

    /**
     * @inheritdoc
     */
    public function isSent(MessageInterface $message): ?bool
    {
        $historyItem = $this->getHistoryItem($message);

        return $historyItem ? $historyItem->isSent() : null;
    }

    /**
     * @inheritdoc
     */
    public function getSender(MessageInterface $message): ?string
    {
        $historyItem = $this->getHistoryItem($message);

        return $historyItem ? $historyItem->getSender() : null;
    }

    /**
     * @return HistoryItem[]
     */
    public function getHistory(): array
    {
        return $this->history;
    }

    public function getHistoryItem(MessageInterface $message): ?HistoryItem
    {
        foreach ($this->history as $item) {
            $isMatch = $item->getRecipient() === $message->getRecipient()
                && $item->getText() === $message->getText();

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
