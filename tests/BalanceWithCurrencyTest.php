<?php

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery\BalanceWithCurrency;

/**
 * Class BalanceWithCurrencyTest
 * @package Wearesho\Delivery\Tests
 */
class BalanceWithCurrencyTest extends TestCase
{
    protected const AMOUNT = 1234.499;
    protected const CURRENCY = 'UAH';

    /** @var BalanceWithCurrency */
    protected $balance;

    protected function setUp(): void
    {
        parent::setUp();

        $this->balance = new BalanceWithCurrency(static::AMOUNT, static::CURRENCY);
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
}
