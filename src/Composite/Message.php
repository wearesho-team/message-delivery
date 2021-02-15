<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

class Message implements MessageInterface
{
    use Delivery\MessageTrait;

    protected array $items;

    public function __construct(string $text, string $recipient, ItemInterface ...$items)
    {
        $this->text = $text;
        $this->recipient = $recipient;
    }
}
