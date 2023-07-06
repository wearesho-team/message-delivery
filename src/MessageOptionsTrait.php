<?php

declare(strict_types=1);

namespace Wearesho\Delivery;

trait MessageOptionsTrait
{
    protected array $options = [];

    public function getOptions(): array
    {
        return $this->options;
    }
}
