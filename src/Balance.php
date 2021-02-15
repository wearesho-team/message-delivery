<?php declare(strict_types=1);

namespace Wearesho\Delivery;

class Balance implements BalanceInterface, \JsonSerializable
{
    use BalanceTrait;

    public function __construct(float $amount, string $currency = null)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function __toString(): string
    {
        $balance = number_format($this->amount, 2);

        if (!is_null($this->currency)) {
            $balance .= " {$this->currency}";
        }

        return $balance;
    }

    public function jsonSerialize(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
