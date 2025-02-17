<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Batch;

use Wearesho\Delivery;

trait ServiceTrait
{
    public function name(): string
    {
        return $this->baseService()->name();
    }

    public function balance(): Delivery\BalanceInterface
    {
        return $this->baseService()->balance();
    }

    public function send(Delivery\MessageInterface $message): Delivery\ResultInterface
    {
        return $this->baseService()->send($message);
    }

    public function batch(iterable $messages): iterable
    {
        foreach ($messages as $message) {
            yield $this->baseService()->send($message);
        }
    }

    abstract protected function baseService(): Delivery\ServiceInterface;
}
