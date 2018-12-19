<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery\Balance;

/**
 * Class BalanceTest
 * @package Wearesho\Delivery\Tests
 */
class BalanceTest extends TestCase
{
    protected const AMOUNT = 1234.499;

    /** @var Balance */
    protected $balance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balance = new Balance(static::AMOUNT);
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(static::AMOUNT, $this->balance->getAmount());
    }

    public function testToString(): void
    {
        $this->assertEquals('1,234.50', (string)$this->balance);
    }
}
