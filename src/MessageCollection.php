<?php

namespace Wearesho\Delivery;

use Wearesho\BaseCollection;

/**
 * Class MessageCollection
 * @package Wearesho\Delivery
 */
class MessageCollection extends BaseCollection
{
    public function type(): string
    {
        return MessageInterface::class;
    }
}
