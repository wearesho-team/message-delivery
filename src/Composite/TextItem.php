<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

class TextItem implements ItemInterface, Delivery\Message\Text
{
    use ItemTrait, Delivery\Message\TextTrait;

    public function __construct(string $compatibleServiceClass, string $text)
    {
        $this->compatibleServiceClass = $compatibleServiceClass;
        $this->text = $text;
    }
}
