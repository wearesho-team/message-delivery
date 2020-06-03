<?php

namespace Wearesho\Delivery\Message;

use Wearesho\Delivery;

class Batch implements BatchInterface
{
    protected int $position = 0;
    protected array $messages;
    protected Delivery\MemoryRepository $history;

    public function __construct(Delivery\MessageInterface $message, ...$messages)
    {
        $this->messages = [$message, ...$messages];
        $this->history = new Delivery\MemoryRepository;
    }

    /**
     * @throws Delivery\Exception
     */
    public function execute(Delivery\ServiceInterface $service)
    {
        $this->history->flush();
        $this->rewind();
        while ($this->valid()) {
            $service->send($this);
            $this->next();
        }
    }

    public static function create(string $text, string $recipient, ...$recipients): self
    {
        return new self(...array_map(
            fn(string $recipient) => new Delivery\Message($text, $recipient),
            [$recipient, ...$recipients]
        ));
    }

    public function current(): Delivery\MessageInterface
    {
        return $this->messages[$this->position];
    }

    public function next(Delivery\HistoryItemInterface $item = null)
    {
        if ($item) {
            $this->history->save($item);
        }
        $this->position += 1;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return array_key_exists($this->position, $this->messages);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function getRecipient(): string
    {
        return $this->current()->getRecipient();
    }

    public function getText(): string
    {
        return $this->current()->getText();
    }

    public function history(): array
    {
        return $this->history->getHistory();
    }
}
