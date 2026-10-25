<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests\History;

use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Wearesho\Delivery;

class ServiceTest extends TestCase
{
    private Delivery\ServiceInterface&MockObject $baseServiceMock;
    private Delivery\History\RepositoryInterface&MockObject $repositoryMock;
    private Delivery\History\Service $historyService;
    private Delivery\BalanceInterface&Stub $balanceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balanceMock = $this->createStub(Delivery\BalanceInterface::class);

        $this->baseServiceMock = $this->createMock(Delivery\Batch\ServiceInterface::class);
        $this->baseServiceMock->method('name')->willReturn('TestService');
        $this->baseServiceMock->method('balance')->willReturn($this->balanceMock);

        $this->repositoryMock = $this->createMock(Delivery\History\RepositoryInterface::class);

        $this->historyService = new Delivery\History\Service(
            $this->baseServiceMock,
            $this->repositoryMock
        );
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testName(): void
    {
        $this->assertEquals('TestService', $this->historyService->name());
    }

    #[AllowMockObjectsWithoutExpectations]
    public function testBalance(): void
    {
        $this->assertSame($this->balanceMock, $this->historyService->balance());
    }

    public function testSend(): void
    {
        // Arrange
        $message = $this->createStub(Delivery\MessageInterface::class);
        $result = $this->createStub(Delivery\ResultInterface::class);
        $historyItem = $this->createStub(Delivery\History\ItemInterface::class);

        $this->baseServiceMock
            ->expects($this->once())
            ->method('send')
            ->with($message)
            ->willReturn($result);

        $this->repositoryMock
            ->expects($this->once())
            ->method('add')
            ->with('TestService', $result)
            ->willReturn($historyItem);

        // Act
        $sendResult = $this->historyService->send($message);

        // Assert
        $this->assertSame($result, $sendResult);
    }

    public function testBatch(): void
    {
        // Arrange
        $messages = [
            $this->createStub(Delivery\MessageInterface::class),
            $this->createStub(Delivery\MessageInterface::class),
        ];

        $results = [
            $this->createStub(Delivery\ResultInterface::class),
            $this->createStub(Delivery\ResultInterface::class),
        ];

        $historyItems = [
            $this->createStub(Delivery\History\ItemInterface::class),
            $this->createStub(Delivery\History\ItemInterface::class),
        ];

        $this->baseServiceMock
            ->expects($this->once())
            ->method('batch')
            ->with($messages)
            ->willReturn($results);

        $this->repositoryMock
            ->expects($this->once())
            ->method('batch')
            ->with('TestService', $results)
            ->willReturn($historyItems);

        // Act
        $batchResults = iterator_to_array($this->historyService->batch($messages));

        // Assert
        $this->assertEquals($results, $batchResults);
    }

    public function testBatchWithEmptyMessages(): void
    {
        // Arrange
        $this->baseServiceMock
            ->expects($this->once())
            ->method('batch')
            ->with([])
            ->willReturn([]);

        $this->repositoryMock
            ->expects($this->never())
            ->method('batch');

        // Act
        $results = iterator_to_array($this->historyService->batch([]));

        // Assert
        $this->assertEmpty($results);
    }

    public function testBatchWithException(): void
    {
        // Arrange
        $messages = [$this->createStub(Delivery\MessageInterface::class)];
        $exception = new \Exception('Test exception');

        $this->baseServiceMock
            ->expects($this->once())
            ->method('batch')
            ->willThrowException($exception);

        $this->repositoryMock
            ->expects($this->never())
            ->method('batch');

        // Act & Assert
        $this->expectException(\Exception::class);
        iterator_to_array($this->historyService->batch($messages));
    }
}
