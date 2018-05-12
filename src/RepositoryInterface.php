<?php

namespace Wearesho\Delivery;

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
     * @param MessageInterface $message
     * @param string $sender Sending channel <ServiceInterface>
     * @param bool $sent If channel correctly sent message
     */
    public function push(MessageInterface $message, string $sender, bool $sent): void;

    /**
     * @param MessageInterface $message
     * @return bool|null
     *
     * MUST return null if message did not sent before
     * MUST return last sent status for message
     * If message sent few times, last status HAVE TO be returned
     */
    public function isSent(MessageInterface $message): ?bool;

    /**
     * @param MessageInterface $message
     * @return null|string
     *
     * MUST return null if message did not sent before
     * MUST return sender if message sent before
     * if message sent few times last sender HAVE TO be returned
     */
    public function getSender(MessageInterface $message): ?string;
}
