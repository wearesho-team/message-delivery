<?php

namespace Wearesho\Delivery\Test;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Provides a base test class for ensuring correct work of
 * @see Delivery\RepositoryTrait
 * abstract methods
 *
 * @mixin TestCase
 */
trait RepositoryTest
{
    /** @var Delivery\RepositoryInterface */
    protected $repository;

    abstract protected function getRepository(): Delivery\RepositoryInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->getRepository();
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
    }
}
