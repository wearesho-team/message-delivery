<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests\History;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Carbon\Carbon;
use Wearesho\Delivery;

class ItemTest extends TestCase
{
    private Delivery\ResultInterface&MockObject $resultMock;
    private Delivery\MessageInterface&MockObject $messageMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageMock = $this->createMock(Delivery\MessageInterface::class);

        $this->resultMock = $this->createMock(Delivery\ResultInterface::class);
        $this->resultMock->method('messageId')->willReturn('msg_123');
        $this->resultMock->method('message')->willReturn($this->messageMock);
        $this->resultMock->method('status')->willReturn(Delivery\Result\Status::Delivered);
        $this->resultMock->method('reason')->willReturn(null);
    }

    /**
     * @dataProvider itemDataProvider
     */
    public function testItemCreationAndGetters(
        int $id,
        string $serviceName,
        ?\DateTimeInterface $at,
        ?\DateTimeInterface $updatedAt
    ): void {
        // Arrange
        Carbon::setTestNow('2025-02-11 12:00:00');

        // Act
        $item = new Delivery\History\Item($id, $this->resultMock, $serviceName, $at, $updatedAt);

        // Assert
        $this->assertEquals($id, $item->id());
        $this->assertSame($this->resultMock, $item->result());
        $this->assertEquals($serviceName, $item->serviceName());

        if ($at === null) {
            $this->assertEquals(Carbon::now(), $item->at());
        } else {
            $this->assertSame($at, $item->at());
        }

        if ($updatedAt === null) {
            $this->assertEquals(Carbon::now(), $item->updatedAt());
        } else {
            $this->assertSame($updatedAt, $item->updatedAt());
        }
    }

    public static function itemDataProvider(): array
    {
        $fixedDate = new Carbon('2025-02-11 10:00:00');
        $updatedDate = new Carbon('2025-02-11 11:00:00');

        return [
            'with_explicit_dates' => [
                'id' => 1,
                'serviceName' => 'serviceNameTest',
                'at' => $fixedDate,
                'updatedAt' => $updatedDate,
            ],
            'with_null_dates' => [
                'id' => 2,
                'serviceName' => 'serviceNameTest',
                'at' => null,
                'updatedAt' => null,
            ],
            'with_only_at_date' => [
                'id' => 3,
                'serviceName' => 'serviceNameTest',
                'at' => $fixedDate,
                'updatedAt' => null,
            ],
            'with_only_updated_at_date' => [
                'id' => 4,
                'serviceName' => 'serviceNameTest',
                'at' => null,
                'updatedAt' => $updatedDate,
            ],
        ];
    }

    public function testResultAccessibility(): void
    {
        // Arrange
        $item = new Delivery\History\Item(1, $this->resultMock, 'serviceName');

        // Act
        $result = $item->result();

        // Assert
        $this->assertEquals('msg_123', $result->messageId());
        $this->assertSame($this->messageMock, $result->message());
        $this->assertEquals(Delivery\Result\Status::Delivered, $result->status());
        $this->assertNull($result->reason());
    }

    public function testDefaultDatesAreSetToCurrentTime(): void
    {
        // Arrange
        $now = new Carbon('2025-02-11 12:00:00');
        Carbon::setTestNow($now);

        // Act
        $item = new Delivery\History\Item(1, $this->resultMock, 'serviceName');

        // Assert
        $this->assertEquals($now, $item->at());
        $this->assertEquals($now, $item->updatedAt());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Carbon::setTestNow(); // Reset Carbon's test time
    }
}
