<?php

namespace Wearesho\Delivery\Message;

trait TextTrait
{
    protected string $text;

    public function getText(): string
    {
        return $this->text;
    }
}
