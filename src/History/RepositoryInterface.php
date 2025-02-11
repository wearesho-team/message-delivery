<?php

declare(strict_types=1);

namespace Wearesho\Delivery\History;

use Wearesho\Delivery;

interface RepositoryInterface
{
    public function add(Delivery\ResultInterface $item): ItemInterface;

    /**
     * @param Delivery\ResultInterface[] $items
     * @return ItemInterface[]
     */
    public function batch(array $items): array;

    public function update(ItemInterface $item, Delivery\ResultInterface $result): ItemInterface;

    public function getById(int $id): ?ItemInterface;

    public function getByResultId(string $resultId): ?ItemInterface;
}
