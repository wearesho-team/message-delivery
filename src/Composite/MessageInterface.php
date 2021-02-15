<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

interface MessageInterface extends Delivery\MessageInterface
{
    public function conform(Delivery\ServiceInterface $service): MessageInterface;
}

