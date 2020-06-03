<?php

namespace Wearesho\Delivery\Message;

use Wearesho\Delivery;

interface BatchInterface extends \Iterator, Delivery\MessageInterface
{
    public function current(): Delivery\MessageInterface;

    public function execute(Delivery\ServiceInterface $service);

    public function history(): array;
}
