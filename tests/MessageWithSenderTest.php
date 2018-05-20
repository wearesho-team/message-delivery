<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class MessageWithSenderTest
 * @package Wearesho\Delivery\Tests
 */
class MessageWithSenderTest extends TestCase
{
    public function testSenderName(): void
    {
        $message = new Delivery\MessageWithSender('text', 'recipient', 'senderName');
        $this->assertEquals('senderName', $message->getSenderName());
    }
}
