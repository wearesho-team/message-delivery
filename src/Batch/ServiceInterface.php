<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Batch;

use Wearesho\Delivery;

interface ServiceInterface extends Delivery\ServiceInterface
{
    /**
     * @param iterable<Delivery\MessageInterface> $messages
     * @return iterable<Delivery\ResultInterface>
     */
    public function batch(iterable $messages): iterable;
}
