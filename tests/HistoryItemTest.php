<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class HistoryItemTest
 * @package Wearesho\Delivery\Tests
 */
class HistoryItemTest extends TestCase
{
    public function testCreate(): void
    {
        $message = new Delivery\Message(
            "text",
            "recipient"
        );

        $before = new \DateTime();
        $item = new Delivery\HistoryItem($message, static::class, true);
        $after = new \DateTime();

        $this->assertEquals("text", $item->getText());
        $this->assertEquals("recipient", $item->getRecipient());

        $this->assertEquals(true, $item->isSent());
        $this->assertEquals(static::class, $item->getSender());
        $this->assertTrue(
            $item->getSentAt() >= $before && $item->getSentAt() <= $after
        );
    }

    public function testCreateWithSender(): void
    {
        $message = new Delivery\MessageWithSender(
            "text",
            "recipient",
            'customSenderName'
        );

        $item = new Delivery\HistoryItem($message, static::class, true);

        $this->assertEquals("text", $item->getText());
        $this->assertEquals("recipient", $item->getRecipient());
        $this->assertEquals('customSenderName', $item->getSenderName());
    }
}
