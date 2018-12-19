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
    protected const CURRENCY = 'UAH';

    /** @var Balance */
    protected $balance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balance = new Balance(static::AMOUNT, static::CURRENCY);
    }

    public function testGetAmount(): void
    {
        $this->assertEquals(static::AMOUNT, $this->balance->getAmount());
    }

    public function testGetCurrency(): void
    {
        $this->assertEquals(static::CURRENCY, $this->balance->getCurrency());
    }

    public function testToString(): void
    {
        $this->assertEquals('1,234.50 UAH', (string)$this->balance);
    }

    public function testWithoutCurrency(): void
    {
        $balance = new Balance(static::AMOUNT);

        $this->assertEquals('1,234.50', (string)$balance);
    }
}
