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
        $message = new Delivery\Message('Text', '380930000000');
        $sender = static::class;
        $isSent = true;

        $before = new \DateTime();
        $this->repository->push($message, $sender, $isSent);
        $after = new \DateTime();

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
            $historyItem->getText(),
            $message->getText()
        );
        $this->assertEquals(
            $historyItem->getRecipient(),
            $message->getRecipient()
        );
        $this->assertEquals(
            $historyItem->getSender(),
            $sender
        );
        $this->assertEquals(
            $before->format('Y-m-d H:i:s'),
            $historyItem->getSentAt()->format('Y-m-d H:i:s')
        );
    }

    public function testPushWithOptions(): void
    {
        $options = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];
        $message = new Delivery\MessageWithOptions('Text', '380930000000', $options);
        $sender = static::class;
        $isSent = true;

        $this->repository->push($message, $sender, $isSent);
        $historyItem = $this->repository->getHistoryItem($message);
        $this->assertInstanceOf(Delivery\HistoryItemWithOptionsInterface::class, $historyItem);
        $this->assertEquals($options, $historyItem->getOptions());
    }
}
