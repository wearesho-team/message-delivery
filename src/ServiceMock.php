<?php


namespace Wearesho\Delivery;

use Wearesho\Delivery;

/**
 * Class ServiceMock
 * @package Wearesho\Delivery
 */
class ServiceMock implements ServiceInterface
{
    protected RepositoryInterface $repository;

    protected bool $willFail = false;

    public function __construct(RepositoryInterface $repository = null)
    {
        $this->repository = $repository ?? new MemoryRepository();
    }

    public function getRepository(): RepositoryInterface
    {
        return $this->repository;
    }

    public function setRepository(RepositoryInterface $repository): ServiceMock
    {
        $this->repository = $repository;
        return $this;
    }

    public function willFail(bool $willFail = true): ServiceMock
    {
        $this->willFail = $willFail;
        return $this;
    }

    public function send(Delivery\MessageInterface $message): void
    {
        $this->repository->push($message, static::class, !$this->willFail);

        if ($this->willFail) {
            throw new Delivery\Exception("Test Fail");
        }
    }
}
