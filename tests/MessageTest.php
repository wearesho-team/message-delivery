<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

class MessageTest extends TestCase
{
    /**
     * @dataProvider messageDataProvider
     */
    public function testMessageCreationAndGetters(
        string $text,
        string $recipient,
        array $options
    ): void {
        // Arrange & Act
        $message = new Delivery\Message($text, $recipient, $options);

        // Assert
        $this->assertEquals($text, $message->getText());
        $this->assertEquals($recipient, $message->getRecipient());
        $this->assertEquals($options, $message->getOptions());
    }

    public static function messageDataProvider(): array
    {
        return [
            'basic_message' => [
                'text' => 'Hello World',
                'recipient' => '+1234567890',
                'options' => [],
            ],
            'message_with_options' => [
                'text' => 'Test message',
                'recipient' => '+9876543210',
                'options' => [
                    'senderName' => 'TestSender',
                    'channel' => 'sms',
                ],
            ],
            'long_message' => [
                'text' => 'This is a very long message that contains multiple words and special characters: !@#$%^&*()',
                'recipient' => '+1122334455',
                'options' => [
                    'priority' => 'high',
                    'validity' => 3600,
                ],
            ],
            'international_message' => [
                'text' => 'こんにちは世界',
                'recipient' => '+819012345678',
                'options' => [
                    'encoding' => 'unicode',
                ],
            ],
            'empty_options' => [
                'text' => 'Simple message',
                'recipient' => '+44123456789',
                'options' => [],
            ],
        ];
    }

    public function testDefaultOptionsAreEmpty(): void
    {
        // Arrange & Act
        $message = new Delivery\Message('text', '+1234567890');

        // Assert
        $this->assertEmpty($message->getOptions());
    }
}
