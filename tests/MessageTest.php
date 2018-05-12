<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class MessageTest
 * @package Wearesho\Delivery\Tests
 * @internal
 */
class MessageTest extends TestCase
{
    public function testGetters(): void
    {
        $text = str_repeat(mt_rand(), 10);
        $recipient = mt_rand(1, 100);

        $message = new Delivery\Message($text, $recipient);

        $this->assertEquals($text, $message->getText());
        $this->assertEquals($recipient, $message->getRecipient());
    }
}
