<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

class Service
{
    protected Delivery\Composite\MessageInterface $message;

    /** @var ItemInterface[] */
    protected array $items;

    public function __construct(Delivery\MessageInterface $message, ItemInterface ...$items)
    {
        $this->items = $items;
    }

    public function to(Delivery\ServiceInterface $service): Delivery\Composite\MessageInterface
    {
        $text = null;
        $recipient = null;


    }

    /**
     * @return ItemInterface
     */
    protected function filter(Delivery\ServiceInterface $service): array
    {

    }
}
