<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests\History;

use Wearesho\Delivery;
use Wearesho\Delivery\History\RepositoryInterface;

class MemoryRepositoryTest extends Delivery\Test\History\RepositoryTest
{
    protected function createRepository(): RepositoryInterface
    {
        return new Delivery\History\MemoryRepository();
    }
}
