<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

interface HistoryItemWithOptionsInterface extends HistoryItemInterface
{
    public function getOptions(): ?array;
}
