<?php

namespace Wearesho\Delivery;

use Wearesho\Delivery;

/**
 * Interface RepositoryInterface
 * Storage for messages
 *
 * MAY be used as dependency for
 * @see ServiceInterface
 *
 * @package Wearesho\Delivery
 */
interface RepositoryInterface
{
    /**
     * @param Delivery\MessageInterface $message
     * @param string $sender Sending channel <ServiceInterface>
     * @param bool $sent If channel correctly sent message
     */
    public function push(Delivery\MessageInterface $message, string $sender, bool $sent): void;

    /**
     * @param Delivery\MessageInterface $message
     * @return bool|null
     *
     * MUST return null if message did not sent before
     * MUST return last sent status for message
     * If message sent few times, last status HAVE TO be returned
     */
    public function isSent(Delivery\MessageInterface $message): ?bool;

    /**
     * @param Delivery\MessageInterface $message
     * @return null|string
     *
     * MUST return null if message did not sent before
     * MUST return sender if message sent before
     * if message sent few times last sender HAVE TO be returned
     */
    public function getSender(Delivery\MessageInterface $message): ?string;

    public function getHistoryItem(Delivery\MessageInterface $message): ?Delivery\HistoryItemInterface;

    public function save(Delivery\HistoryItemInterface $item): void;
}
