<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

interface MessageInterface
{
    public function getText(): string;

    public function getRecipient(): string;

    public function getOptions(): array;
}
