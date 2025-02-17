<?php

namespace Wearesho\Delivery\Tests\Batch;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Wearesho\Delivery;

class ServiceTest extends TestCase
{
    private Delivery\ServiceInterface&MockObject $baseServiceMock;
    private Delivery\Batch\Service $batchService;
    private Delivery\BalanceInterface&MockObject $balanceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balanceMock = $this->createMock(Delivery\BalanceInterface::class);

        $this->baseServiceMock = $this->createMock(Delivery\ServiceInterface::class);
        $this->baseServiceMock->method('name')->willReturn('TestService');
        $this->baseServiceMock->method('balance')->willReturn($this->balanceMock);

        $this->batchService = new Delivery\Batch\Service($this->baseServiceMock);
    }

    public function testName(): void
    {
        // Act
        $name = $this->batchService->name();

        // Assert
        $this->assertEquals('TestService', $name);
    }

    public function testBalance(): void
    {
        // Act
        $balance = $this->batchService->balance();

        // Assert
        $this->assertSame($this->balanceMock, $balance);
    }

    public function testSend(): void
    {
        // Arrange
        $message = $this->createMock(Delivery\MessageInterface::class);
        $result = $this->createMock(Delivery\ResultInterface::class);

        $this->baseServiceMock
            ->expects($this->once())
            ->method('send')
            ->with($message)
            ->willReturn($result);

        // Act
        $sendResult = $this->batchService->send($message);

        // Assert
        $this->assertSame($result, $sendResult);
    }

    public function testBatch(): void
    {
        // Arrange
        $messages = [];
        $expectedResults = [];

        $this->baseServiceMock
            ->expects($this->exactly(3))
            ->method('send')
            ->willReturnCallback(function (Delivery\MessageInterface $message) use (&$messages, &$expectedResults) {
                $result = $this->createMock(Delivery\ResultInterface::class);
                $messages[] = $message;
                $expectedResults[] = $result;
                return $result;
            });

        $testMessages = [
            $this->createMock(Delivery\MessageInterface::class),
            $this->createMock(Delivery\MessageInterface::class),
            $this->createMock(Delivery\MessageInterface::class),
        ];

        // Act
        $results = iterator_to_array($this->batchService->batch($testMessages));

        // Assert
        $this->assertCount(3, $results);
        $this->assertEquals($expectedResults, $results);
        $this->assertEquals($testMessages, $messages);
    }

    public function testBatchWithEmptyMessages(): void
    {
        // Arrange
        $messages = [];

        // Act
        $results = iterator_to_array($this->batchService->batch($messages));

        // Assert
        $this->assertEmpty($results);

        $this->baseServiceMock
            ->expects($this->never())
            ->method('send');
    }

    public function testBatchWithException(): void
    {
        // Arrange
        $message1 = $this->createMock(Delivery\MessageInterface::class);
        $message2 = $this->createMock(Delivery\MessageInterface::class);
        $result1 = $this->createMock(Delivery\ResultInterface::class);

        $this->baseServiceMock
            ->expects($this->exactly(2))
            ->method('send')
            ->willReturnCallback(function ($message) use ($message1, $result1) {
                if ($message === $message1) {
                    return $result1;
                }
                throw new Delivery\Exception('Test exception');
            });

        // Act & Assert
        $this->expectException(Delivery\Exception::class);

        $results = [];
        foreach ($this->batchService->batch([$message1, $message2]) as $result) {
            $results[] = $result;
        }

        // Verify first message was processed before exception
        $this->assertCount(1, $results);
        $this->assertSame($result1, $results[0]);
    }

    public function testBatchWrap(): void
    {
        $service = Delivery\Batch\Service::wrap($this->baseServiceMock);
        $this->assertEquals('TestService', $service->name());
    }

    public function testBatchWrapBatchService(): void
    {
        $serviceName = 'TestServiceBatch';

        $serviceMock = $this->createMock(Delivery\Batch\ServiceInterface::class);
        $serviceMock->method('name')->willReturn($serviceName);

        $service = Delivery\Batch\Service::wrap($serviceMock);
        $this->assertEquals($serviceName, $service->name());
    }
}
