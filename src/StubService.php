<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

use Wearesho\Delivery;

class StubService implements Batch\ServiceInterface
{
    public function name(): string
    {
        return "stub";
    }

    public function balance(): BalanceInterface
    {
        return new Balance(0, "USD");
    }

    public function batch(iterable $messages): iterable
    {
        foreach ($messages as $message) {
            yield $this->createResult($message);
        }
    }

    public function send(MessageInterface $message): ResultInterface
    {
        return $this->createResult($message);
    }

    private function createResult(MessageInterface $message): ResultInterface
    {
        return new Result(
            messageId: uniqid('stub_', more_entropy: true),
            message: $message,
            status: Result\Status::Delivered,
        );
    }
}
