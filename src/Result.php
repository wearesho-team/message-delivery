<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

class Result implements ResultInterface
{
    public function __construct(
        private readonly string $messageId,
        private readonly MessageInterface $message,
        private readonly Result\Status $status,
        private readonly ?string $reason = null
    ) {
    }

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function message(): MessageInterface
    {
        return $this->message;
    }

    public function status(): Result\Status
    {
        return $this->status;
    }

    public function reason(): ?string
    {
        return $this->reason;
    }
}
