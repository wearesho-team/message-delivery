<?php

namespace Wearesho\Delivery\Tests\Message;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

/**
 * Class BatchTest
 * @package Wearesho\Delivery\Tests\Message
 */
class BatchTest extends TestCase
{
    public function testExecute(): void
    {
        $messages = [
            new Delivery\Message(PHP_VERSION, 'callback'),
            $this->getMockForAbstractClass(Delivery\MessageInterface::class),
            new Delivery\Message(str_shuffle(PHP_VERSION), 'callback'),
        ];
        $batch = new Delivery\Message\Batch(...$messages);

        $service = $this->getMockForAbstractClass(Delivery\ServiceInterface::class);
        $service->expects($this->exactly(2))
            ->method('send')
            ->willReturnCallback(function (Delivery\Message\Batch $batch) use (&$i, $messages) {
                $message = $messages[$batch->key()];
                $this->assertEquals($message->getText(), $batch->getText());
                $this->assertEquals($message->getRecipient(), $batch->getRecipient());
                $batch->next();
            });
        $batch->execute($service);
    }

    public function testHistory(): void
    {
        $batch = new Delivery\Message\Batch(
            $this->getMockForAbstractClass(Delivery\MessageInterface::class)
        );
        $item = $this->getMockForAbstractClass(Delivery\HistoryItemInterface::class);
        $batch->next($this->getMockForAbstractClass(Delivery\HistoryItemInterface::class));
        $this->assertEquals([$item], $batch->history());


        $batch->execute($this->getMockForAbstractClass(Delivery\ServiceInterface::class));
        $this->assertCount(0, $batch->history());
    }

    public function testCreate(): void
    {
        $text = 'CommonText';
        $recipients = ['first', 'second', 'third'];

        $batch = Delivery\Message\Batch::create($text, ...$recipients);
        $messages = iterator_to_array($batch);
        $this->assertCount(count($recipients), $messages);
        /** @var Delivery\MessageInterface $message */
        foreach ($messages as $i => $message) {
            $this->assertEquals($recipients[$i], $message->getRecipient());
            $this->assertEquals($text, $message->getText());
        }
    }
}
