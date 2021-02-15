<?php declare(strict_types=1);

namespace Wearesho\Delivery\Composite;

use Wearesho\Delivery;

trait ItemTrait
{
    public string $compatibleServiceClass;

    public function matchUp(Delivery\ServiceInterface $service): bool
    {
        return $service instanceof $this->compatibleServiceClass;
    }
}
