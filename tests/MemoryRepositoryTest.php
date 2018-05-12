<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class MemoryRepositoryTest
 * @package Wearesho\Delivery\Tests
 */
class MemoryRepositoryTest extends TestCase
{
    /** @var Delivery\MemoryRepository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new Delivery\MemoryRepository();
    }

    public function testPush(): void
    {
        $message = new Delivery\Message(1, 2);
        $sender = static::class;
        $isSent = true;

        $this->repository->push($message, $sender, $isSent);

        $this->assertEquals(
            $sender,
            $this->repository->getSender($message)
        );

        $this->assertEquals(
            $isSent,
            $this->repository->isSent($message)
        );

        $historyItem = $this->repository->getHistoryItem($message);

        $this->assertEquals(
            new Delivery\HistoryItem($message, $sender, $isSent, $historyItem->getSentAt()),
            $historyItem
        );

        $this->assertEquals(
            [$historyItem],
            $this->repository->getHistory()
        );

        $this->repository->flush();
        $this->assertEquals([], $this->repository->getHistory());
        $this->assertNull($this->repository->getHistoryItem($message));
    }
}
