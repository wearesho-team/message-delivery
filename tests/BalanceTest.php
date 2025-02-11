<?php

declare(strict_types=1);

namespace Wearesho\Delivery\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Delivery;

class BalanceTest extends TestCase
{
    /**
     * @dataProvider balanceDataProvider
     */
    public function testBalanceCreationAndGetters(
        float $amount,
        ?string $currency,
        string $expectedString,
        array $expectedJson
    ): void {
        // Arrange & Act
        $balance = new Delivery\Balance($amount, $currency);

        // Assert
        $this->assertEquals($amount, $balance->getAmount());
        $this->assertEquals($currency, $balance->getCurrency());
        $this->assertEquals($expectedString, (string)$balance);
        $this->assertEquals($expectedJson, $balance->jsonSerialize());
    }

    public static function balanceDataProvider(): array
    {
        return [
            'positive_with_currency' => [
                'amount' => 100.50,
                'currency' => 'USD',
                'expectedString' => '100.50 USD',
                'expectedJson' => [
                    'amount' => 100.50,
                    'currency' => 'USD',
                ],
            ],
            'negative_with_currency' => [
                'amount' => -50.75,
                'currency' => 'EUR',
                'expectedString' => '-50.75 EUR',
                'expectedJson' => [
                    'amount' => -50.75,
                    'currency' => 'EUR',
                ],
            ],
            'zero_with_currency' => [
                'amount' => 0.00,
                'currency' => 'GBP',
                'expectedString' => '0.00 GBP',
                'expectedJson' => [
                    'amount' => 0.00,
                    'currency' => 'GBP',
                ],
            ],
            'without_currency' => [
                'amount' => 75.25,
                'currency' => null,
                'expectedString' => '75.25',
                'expectedJson' => [
                    'amount' => 75.25,
                    'currency' => null,
                ],
            ],
            'large_number' => [
                'amount' => 1000000.00,
                'currency' => 'JPY',
                'expectedString' => '1,000,000.00 JPY',
                'expectedJson' => [
                    'amount' => 1000000.00,
                    'currency' => 'JPY',
                ],
            ],
        ];
    }

    /**
     * @dataProvider numberFormatDataProvider
     */
    public function testNumberFormatting(float $amount, string $expectedFormat): void
    {
        // Arrange & Act
        $balance = new Delivery\Balance($amount);

        // Assert
        $this->assertEquals($expectedFormat, (string)$balance);
    }

    public static function numberFormatDataProvider(): array
    {
        return [
            'two_decimal_places' => [
                'amount' => 10.1,
                'expectedFormat' => '10.10',
            ],
            'round_three_decimals' => [
                'amount' => 10.999,
                'expectedFormat' => '11.00',
            ],
            'zero_decimals' => [
                'amount' => 10.0,
                'expectedFormat' => '10.00',
            ],
        ];
    }

    public function testJsonEncodeBalance(): void
    {
        // Arrange
        $balance = new Delivery\Balance(99.99, 'USD');

        // Act
        $jsonString = json_encode($balance);

        // Assert
        $this->assertJson($jsonString);
        $this->assertEquals(
            '{"amount":99.99,"currency":"USD"}',
            $jsonString
        );
    }

    /**
     * @dataProvider stringCastDataProvider
     */
    public function testStringCasting(float $amount, ?string $currency, string $expected): void
    {
        // Arrange
        $balance = new Delivery\Balance($amount, $currency);

        // Act & Assert
        $this->assertEquals($expected, (string)$balance);
        $this->assertEquals($expected, $balance->__toString());
    }

    public static function stringCastDataProvider(): array
    {
        return [
            'with_currency' => [
                'amount' => 123.45,
                'currency' => 'USD',
                'expected' => '123.45 USD',
            ],
            'without_currency' => [
                'amount' => 123.45,
                'currency' => null,
                'expected' => '123.45',
            ],
            'zero_amount' => [
                'amount' => 0.00,
                'currency' => 'EUR',
                'expected' => '0.00 EUR',
            ],
        ];
    }
}
