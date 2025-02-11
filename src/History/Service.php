<?php

declare(strict_types=1);

namespace Wearesho\Delivery\History;

use Wearesho\Delivery;
use Wearesho\Delivery\BalanceInterface;
use Wearesho\Delivery\ResultInterface;

class Service implements Delivery\Batch\ServiceInterface
{
    public function __construct(
        private readonly Delivery\Batch\ServiceInterface $service,
        private readonly RepositoryInterface $repository
    ) {
    }

    public function balance(): BalanceInterface
    {
        return $this->service->balance();
    }

    public function name(): string
    {
        return $this->service->name();
    }

    public function send(Delivery\MessageInterface $message): ResultInterface
    {
        $result = $this->service->send($message);
        $this->repository->add($result);
        return $result;
    }

    public function batch(iterable $messages): iterable
    {
        $results = [];
        foreach ($this->service->batch($messages) as $resultItem) {
            $results[] = $resultItem;
            yield $resultItem;
        }
        if (!empty($results)) {
            $this->repository->batch($results);
        }
    }
}
