<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

class ResultTest extends TestCase
{
    /**
     * @dataProvider resultDataProvider
     */
    public function testResultCreationAndGetters(
        string $messageId,
        string $messageText,
        string $recipient,
        array $options,
        Delivery\Result\Status $status,
        ?string $reason
    ): void {
        // Arrange
        $message = $this->createMessageMock($messageText, $recipient, $options);

        // Act
        $result = new Delivery\Result($messageId, $message, $status, $reason);

        // Assert
        $this->assertEquals($messageId, $result->messageId());
        $this->assertSame($message, $result->message());
        $this->assertEquals($status, $result->status());
        $this->assertEquals($reason, $result->reason());

        // Additional assertions for message content
        $this->assertEquals($messageText, $result->message()->getText());
        $this->assertEquals($recipient, $result->message()->getRecipient());
        $this->assertEquals($options, $result->message()->getOptions());
    }

    public static function resultDataProvider(): array
    {
        return [
            'successful_delivery' => [
                'messageId' => 'msg_123',
                'messageText' => 'Hello World',
                'recipient' => '+1234567890',
                'options' => ['priority' => 'high'],
                'status' => Delivery\Result\Status::Delivered,
                'reason' => null,
            ],
            'queued_message' => [
                'messageId' => 'msg_456',
                'messageText' => 'Test message',
                'recipient' => '+9876543210',
                'options' => [],
                'status' => Delivery\Result\Status::Queued,
                'reason' => null,
            ],
            'failed_delivery' => [
                'messageId' => 'msg_789',
                'messageText' => 'Failed message',
                'recipient' => '+1122334455',
                'options' => ['retry' => true],
                'status' => Delivery\Result\Status::Failed,
                'reason' => 'Network timeout',
            ],
            'rejected_message' => [
                'messageId' => 'msg_000',
                'messageText' => 'Rejected content',
                'recipient' => '+5544332211',
                'options' => ['validate' => true],
                'status' => Delivery\Result\Status::Rejected,
                'reason' => 'Invalid recipient format',
            ],
        ];
    }

    /**
     * Creates a mock for MessageInterface
     */
    private function createMessageMock(
        string $text,
        string $recipient,
        array $options
    ): Delivery\MessageInterface&MockObject {
        $message = $this->createMock(Delivery\MessageInterface::class);

        $message->method('getText')
            ->willReturn($text);

        $message->method('getRecipient')
            ->willReturn($recipient);

        $message->method('getOptions')
            ->willReturn($options);

        return $message;
    }
}
