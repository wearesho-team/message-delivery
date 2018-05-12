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
    use RepositoryTrait;

    protected $history = [];

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

    public function save(HistoryItemInterface $item): void
    {
        $this->history[] = $item;
    }
}
