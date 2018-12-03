<?php

namespace Wearesho\Delivery\Tests;

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

    public function testGetNull(): void
    {
        $this->assertNull(
            $this->repository->getHistoryItem(new Delivery\Message("text", "recipient"))
        );
    }

    public function testFlushing(): void
    {
        $message = new Delivery\Message("text", "recipient");
        $item = new Delivery\HistoryItem($message, static::class, true, new \DateTime);

        $this->repository->save($item);

        $history = $this->repository->getHistory();
        $this->assertCount(1, $history);
        $this->assertEquals([$item], $history);

        $this->repository->flush();

        $this->assertCount(0, $this->repository->getHistory());
    }
}
