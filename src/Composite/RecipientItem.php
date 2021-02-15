<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

class RecipientItem implements ItemInterface, Delivery\Message\Recipient
{
    use ItemTrait, Delivery\Message\RecipientTrait;

    public function __construct(string $compatibleServiceClass, string $recipient)
    {
        $this->compatibleServiceClass = $compatibleServiceClass;
        $this->recipient = $recipient;
    }
}
