<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Batch;

use Wearesho\Delivery;
use Wearesho\Delivery\BalanceInterface;
use Wearesho\Delivery\ResultInterface;

class Service implements ServiceInterface
{
    public function __construct(private readonly Delivery\ServiceInterface $service)
    {
    }

    public function name(): string
    {
        return $this->service->name();
    }

    public function balance(): BalanceInterface
    {
        return $this->service->balance();
    }

    public function send(Delivery\MessageInterface $message): ResultInterface
    {
        return $this->service->send($message);
    }

    public function batch(iterable $messages): iterable
    {
        foreach ($messages as $message) {
            yield $this->service->send($message);
        }
    }
}
