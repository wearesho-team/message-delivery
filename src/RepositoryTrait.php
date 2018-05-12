<?php

namespace Wearesho\Delivery;

/**
 * Trait RepositoryTrait
 * @package Wearesho\Delivery
 */
trait RepositoryTrait
{
    /**
     * @inheritdoc
     */
    public function push(MessageInterface $message, string $sender, bool $sent): void
    {
        $item = new HistoryItem($message, $sender, $sent, new \DateTime());
        $this->save($item);
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

    abstract public function getHistoryItem(MessageInterface $message = null): ?HistoryItemInterface;

    abstract public function save(HistoryItemInterface $item): void;
}
