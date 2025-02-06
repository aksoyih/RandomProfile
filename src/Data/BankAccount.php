<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use JsonSerializable;

final class BankAccount implements JsonSerializable
{
    public function __construct(
        private readonly string $iban,
        private readonly string $bic,
        private readonly string $bank,
        private readonly string $currency,
        private readonly float $balance,
        private readonly float $debt,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'iban' => $this->iban,
            'bic' => $this->bic,
            'bank' => $this->bank,
            'currency' => $this->currency,
            'balance' => $this->balance,
            'debt' => $this->debt,
        ];
    }
}