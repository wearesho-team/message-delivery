<?php

namespace Wearesho\Delivery\Tests;

use Wearesho\Delivery;
use PHPUnit\Framework\TestCase;

/**
 * Class ServiceMockTest
 * @package Wearesho\Delivery\Tests
 * @internal
 */
class ServiceMockTest extends TestCase
{
    /** @var Delivery\ServiceMock */
    protected $service;

    /** @var Delivery\MemoryRepository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new Delivery\ServiceMock();
        $this->repository = new Delivery\MemoryRepository();
        $this->assertInstanceOf(
            Delivery\MemoryRepository::class,
            $this->service->getRepository()
        );
        $this->service->setRepository($this->repository);
        $this->assertEquals($this->repository, $this->service->getRepository());
    }

    public function testSuccessful(): void
    {
        $message = new Delivery\Message(1, 2);

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->service->send($message);

        $this->assertNotNull($this->repository->getHistoryItem($message));
    }

    public function testFail(): void
    {
        $message = new Delivery\Message(1, 2);

        $this->expectException(\Wearesho\Delivery\Exception::class);
        $this->expectExceptionMessage('Test Fail');
        try {
            $this->service
                ->willFail()
                ->send($message);
        } catch (Delivery\Exception $exception) {
            $this->assertFalse(
                $this->repository->isSent($message)
            );
            throw $exception;
        }
    }
}
