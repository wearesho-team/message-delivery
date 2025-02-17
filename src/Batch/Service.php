<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Batch;

use Wearesho\Delivery;
use Wearesho\Delivery\BalanceInterface;
use Wearesho\Delivery\ResultInterface;

class Service implements ServiceInterface
{
    use ServiceTrait;

    public function __construct(private readonly Delivery\ServiceInterface $service)
    {
    }

    public static function wrap(Delivery\ServiceInterface $service): Delivery\Batch\ServiceInterface
    {
        if ($service instanceof Delivery\Batch\ServiceInterface) {
            return $service;
        }
        return new self($service);
    }

    protected function baseService(): Delivery\ServiceInterface
    {
        return $this->service;
    }
}
