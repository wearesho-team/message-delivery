<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Test\History;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery\History\RepositoryInterface;
use Wearesho\Delivery\History\ItemInterface;
use Wearesho\Delivery\ResultInterface;
use Wearesho\Delivery\MessageInterface;
use Wearesho\Delivery\Result;

abstract class RepositoryTest extends TestCase
{
    protected RepositoryInterface $repository;

    abstract protected function createRepository(): RepositoryInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->createRepository();
    }

    public function testAdd(): void
    {
        // Arrange
        $result = $this->createResult('msg_123');

        // Act
        $item = $this->repository->add($result);

        // Assert
        $this->assertInstanceOf(ItemInterface::class, $item);
        $this->validateItem($item, $result);

        // Verify item can be retrieved
        $retrievedById = $this->repository->getById($item->id());
        $this->assertNotNull($retrievedById);
        $this->assertEquals($item->id(), $retrievedById->id());

        $retrievedByResultId = $this->repository->getByResultId($result->messageId());
        $this->assertNotNull($retrievedByResultId);
        $this->assertEquals($item->id(), $retrievedByResultId->id());
    }

    public function testGetById(): void
    {
        // Test non-existent item
        $this->assertNull($this->repository->getById(999999));

        // Test existing item
        $result = $this->createResult('msg_123');
        $addedItem = $this->repository->add($result);

        $item = $this->repository->getById($addedItem->id());
        $this->assertNotNull($item);
        $this->assertEquals($addedItem->id(), $item->id());
        $this->validateItem($item, $result);
    }

    public function testGetByResultId(): void
    {
        // Test non-existent item
        $this->assertNull($this->repository->getByResultId('non_existent_id'));

        // Test existing item
        $result = $this->createResult('msg_456');
        $addedItem = $this->repository->add($result);

        $item = $this->repository->getByResultId($result->messageId());
        $this->assertNotNull($item);
        $this->assertEquals($addedItem->id(), $item->id());
        $this->validateItem($item, $result);
    }

    public function testBatch(): void
    {
        // Arrange
        $results = [
            $this->createResult('msg_1'),
            $this->createResult('msg_2'),
            $this->createResult('msg_3'),
        ];

        // Act
        $items = $this->repository->batch($results);

        // Assert
        $this->assertCount(count($results), $items);
        foreach ($items as $index => $item) {
            $this->assertInstanceOf(ItemInterface::class, $item);
            $this->validateItem($item, $results[$index]);

            // Verify each item can be retrieved
            $retrievedById = $this->repository->getById($item->id());
            $this->assertNotNull($retrievedById);
            $this->assertEquals($item->id(), $retrievedById->id());

            $retrievedByResultId = $this->repository->getByResultId($results[$index]->messageId());
            $this->assertNotNull($retrievedByResultId);
            $this->assertEquals($item->id(), $retrievedByResultId->id());
        }
    }

    public function testUpdate(): void
    {
        // Arrange
        $initialResult = $this->createResult('msg_789', Result\Status::Sent);
        $item = $this->repository->add($initialResult);

        $updatedResult = $this->createResult('msg_789', Result\Status::Delivered);

        // Act
        $updatedItem = $this->repository->update($item, $updatedResult);

        // Assert
        $this->assertEquals($item->id(), $updatedItem->id());
        $this->validateItem($updatedItem, $updatedResult);
        $this->assertGreaterThanOrEqual($item->at(), $updatedItem->at());
        $this->assertGreaterThanOrEqual($item->updatedAt(), $updatedItem->updatedAt());

        // Verify updated item can be retrieved
        $retrievedById = $this->repository->getById($updatedItem->id());
        $this->assertNotNull($retrievedById);
        $this->assertEquals($updatedItem->id(), $retrievedById->id());
        $this->assertEquals($updatedResult->status(), $retrievedById->result()->status());

        $retrievedByResultId = $this->repository->getByResultId($updatedResult->messageId());
        $this->assertNotNull($retrievedByResultId);
        $this->assertEquals($updatedItem->id(), $retrievedByResultId->id());
        $this->assertEquals($updatedResult->status(), $retrievedByResultId->result()->status());
    }

    public function testBatchWithEmptyArray(): void
    {
        $items = $this->repository->batch([]);
        $this->assertIsArray($items);
        $this->assertEmpty($items);
    }

    public function testUpdateNonExistentItem(): void
    {
        // Arrange
        $result = $this->createResult('msg_999');
        $nonExistentItem = $this->createMock(ItemInterface::class);
        $nonExistentItem->method('id')->willReturn(999999);

        // Act & Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->repository->update($nonExistentItem, $result);
    }

    protected function createResult(
        string $messageId,
        Result\Status $status = Result\Status::Sent
    ): ResultInterface {
        $message = $this->createMock(MessageInterface::class);
        $message->method('getText')->willReturn('Test message');
        $message->method('getRecipient')->willReturn('+1234567890');
        $message->method('getOptions')->willReturn([]);

        return new Result(
            messageId: $messageId,
            message: $message,
            status: $status,
            reason: null
        );
    }

    protected function validateItem(ItemInterface $item, ResultInterface $result): void
    {
        $this->assertGreaterThan(0, $item->id());
        $this->assertEquals($result->messageId(), $item->result()->messageId());
        $this->assertEquals($result->status(), $item->result()->status());
        $this->assertEquals($result->reason(), $item->result()->reason());
        $this->assertEquals(
            $result->message()->getText(),
            $item->result()->message()->getText()
        );
        $this->assertEquals(
            $result->message()->getRecipient(),
            $item->result()->message()->getRecipient()
        );
        $this->assertEquals(
            $result->message()->getOptions(),
            $item->result()->message()->getOptions()
        );
        $this->assertInstanceOf(\DateTimeInterface::class, $item->at());
        $this->assertInstanceOf(\DateTimeInterface::class, $item->updatedAt());
    }
}
