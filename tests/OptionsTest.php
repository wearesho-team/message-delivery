<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

class OptionsTest extends TestCase
{
    /**
     * @dataProvider optionsDataProvider
     */
    public function testGet(array $messageOptions, string $optionKey, mixed $expectedResult): void
    {
        // Arrange
        $message = $this->createMessageMock($messageOptions);

        // Act
        $result = Delivery\Options::get($message, $optionKey);

        // Assert
        $this->assertSame($expectedResult, $result);
    }

    public static function optionsDataProvider(): array
    {
        return [
            'existing_sender_name' => [
                'messageOptions' => [Delivery\Options::SENDER_NAME => 'TestSender'],
                'optionKey' => Delivery\Options::SENDER_NAME,
                'expectedResult' => 'TestSender',
            ],
            'existing_channel' => [
                'messageOptions' => [Delivery\Options::CHANNEL => 'sms'],
                'optionKey' => Delivery\Options::CHANNEL,
                'expectedResult' => 'sms',
            ],
            'multiple_options' => [
                'messageOptions' => [
                    Delivery\Options::SENDER_NAME => 'Company',
                    Delivery\Options::CHANNEL => 'whatsapp',
                ],
                'optionKey' => Delivery\Options::SENDER_NAME,
                'expectedResult' => 'Company',
            ],
            'non_existent_option' => [
                'messageOptions' => [Delivery\Options::SENDER_NAME => 'TestSender'],
                'optionKey' => 'nonExistentKey',
                'expectedResult' => null,
            ],
            'empty_options' => [
                'messageOptions' => [],
                'optionKey' => Delivery\Options::CHANNEL,
                'expectedResult' => null,
            ],
        ];
    }

    /**
     * Creates a mock for MessageInterface
     */
    private function createMessageMock(array $options): Delivery\MessageInterface&MockObject
    {
        $message = $this->createMock(Delivery\MessageInterface::class);
        $message->method('getOptions')
            ->willReturn($options);
        return $message;
    }
}
