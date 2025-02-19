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
        $time = time();
        foreach ($messages as $i => $message) {
            yield $this->createResult($message, $time, $i);
        }
    }

    public function send(MessageInterface $message): ResultInterface
    {
        return $this->createResult(
            $message,
            time(),
            0
        );
    }

    private function createResult(
        MessageInterface $message,
        int $time,
        string|int $index
    ): ResultInterface {
        return new Result(
            messageId: "stub_" . $time . "_" . $index,
            message: $message,
            status: Result\Status::Delivered,
        );
    }
}
