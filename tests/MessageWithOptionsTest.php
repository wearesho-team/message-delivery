<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

class MessageWithOptionsTest extends TestCase
{
    public function testOptions(): void
    {
        $options = [
            Delivery\MessageOptionsInterface::OPTION_SENDER_NAME => 'generic',
            Delivery\MessageOptionsInterface::OPTION_CHANNEL => 'dnd',
        ];
        $message = new Delivery\MessageWithOptions('text', 'recipient', $options);
        $this->assertEquals($options, $message->getOptions());
    }
}
