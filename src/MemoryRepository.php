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

    public function getHistoryItem(MessageInterface $message): ?HistoryItemInterface
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

    public function save(HistoryItemInterface $item): void
    {
        $this->history[] = $item;
    }

    public function flush(): void
    {
        $this->history = [];
    }

    /**
     * @return HistoryItem[]
     */
    public function getHistory(): array
    {
        return $this->history;
    }
}
