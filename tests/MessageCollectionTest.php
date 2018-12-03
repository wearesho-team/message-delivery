<?php

namespace Wearesho\Delivery\Tests;

use Wearesho\Delivery\MessageCollection;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery\MessageInterface;

/**
 * Class MessageCollectionTest
 * @package Wearesho\Delivery\Tests
 * @coversDefaultClass MessageCollection
 * @internal
 */
class MessageCollectionTest extends TestCase
{
    /** @var MessageCollection */
    protected $fakeMessageCollection;

    protected function setUp(): void
    {
        $this->fakeMessageCollection = new MessageCollection();
    }

    public function testType(): void
    {
        $this->assertEquals(
            MessageInterface::class,
            $this->fakeMessageCollection->type()
        );
    }
}
