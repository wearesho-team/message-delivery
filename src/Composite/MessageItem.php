<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

class MessageItem implements ItemInterface, Delivery\MessageInterface
{
    use ItemTrait, Delivery\MessageTrait;

    public function __construct(string $compatibleServiceClass, string $text, string $recipient)
    {
        $this->compatibleServiceClass = $compatibleServiceClass;
        $this->text = $text;
        $this->recipient = $recipient;
    }
}
