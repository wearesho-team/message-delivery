<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class MemoryRepositoryTest
 * @package Wearesho\Delivery\Tests
 *
 * @property-read Delivery\MemoryRepository $repository
 */
class MemoryRepositoryTest extends TestCase
{
    use Delivery\Test\RepositoryTest;

    protected function getRepository(): Delivery\RepositoryInterface
    {
        return new Delivery\MemoryRepository();
    }

    public function testPushBatch(): void
    {
        $batch = $this->getMockForAbstractClass(Delivery\Message\BatchInterface::class);
        $batch->expects($this->once())->method('valid')->willReturn(false);

        $history = array_map(
            fn() => $this->getMockForAbstractClass(Delivery\HistoryItemInterface::class),
            range(0, 6)
        );
        $batch->expects($this->once())->method('history')->willReturn($history);

        /** @var Delivery\RepositoryTrait|MockObject $repository */
        $repository = $this->getMockForTrait(Delivery\RepositoryTrait::class);
        $repository->expects($this->exactly(count($history)))
            ->method('save')
            ->withConsecutive(...array_map(fn($i) => [$i], $history));

        $repository->push($batch, static::class, true);
    }

    public function testGetNull(): void
    {
        $this->assertNull(
            $this->repository->getHistoryItem(new Delivery\Message("text", "recipient"))
        );
    }

    public function testFlushing(): void
    {
        $message = new Delivery\Message("text", "recipient");
        $item = new Delivery\HistoryItem($message, static::class, true, new \DateTime());

        $this->repository->save($item);

        $history = $this->repository->getHistory();
        $this->assertCount(1, $history);
        $this->assertEquals([$item], $history);

        $this->repository->flush();

        $this->assertCount(0, $this->repository->getHistory());
    }
}
