<?php declare(strict_types=1);

namespace Wearesho\Delivery\Tests\Composite\Conform;

use Wearesho\Delivery;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testTo(): void {
        $initialText = 'Hello via default channel.';
        $initialRecipient = '380000000000'; // default, sms format
        $message = new Delivery\Message($initialText, $initialRecipient);

        $items = [

        ];
    }
}
