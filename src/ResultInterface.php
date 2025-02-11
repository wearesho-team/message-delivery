<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

interface ResultInterface
{
    public function messageId(): string;
    public function message(): MessageInterface;
    public function status(): Result\Status;
    public function reason(): ?string;
}
