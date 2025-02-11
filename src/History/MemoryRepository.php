<?php

declare(strict_types=1);

namespace Wearesho\Delivery\History;

use Wearesho\Delivery;

class MemoryRepository implements RepositoryInterface
{
    /** @var ItemInterface[] */
    private array $history = [];

    public function add(string $serviceName, Delivery\ResultInterface $item): ItemInterface
    {
        return $this->history[] = new Item(
            id: count($this->history),
            result: $item,
            serviceName: $serviceName,
        );
    }

    public function batch(string $serviceName, array $items): array
    {
        return array_map(
            fn(Delivery\ResultInterface $result) => $this->add($serviceName, $result),
            $items
        );
    }

    public function update(
        ItemInterface $item,
        Delivery\ResultInterface $result,
        ?string $serviceName = null
    ): ItemInterface {
        if (!array_key_exists($item->id(), $this->history)) {
            throw new \InvalidArgumentException("Item {$item->id()} not found");
        }
        return $this->history[$item->id()] = new Item(
            id: $item->id(),
            result: $result,
            serviceName: $serviceName ?? $item->serviceName(),
            at: $item->at(),
        );
    }

    public function getById(int $id): ?ItemInterface
    {
        return $this->history[$id] ?? null;
    }

    public function getByResultId(string $serviceName, string $resultId): ?ItemInterface
    {
        foreach ($this->history as $historyItem) {
            if ($historyItem->result()->messageId() === $resultId) {
                return $historyItem;
            }
        }
        return null;
    }
}
