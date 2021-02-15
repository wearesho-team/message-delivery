<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

interface ItemInterface
{
    public function matchUp(Delivery\ServiceInterface $service): bool;
}
