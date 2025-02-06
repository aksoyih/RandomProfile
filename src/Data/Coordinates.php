<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use JsonSerializable;

final class Coordinates implements JsonSerializable
{
    public function __construct(
        private readonly string $latitude,
        private readonly string $longitude,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'latitute' => $this->latitude,
            'longitute' => $this->longitude,
        ];
    }
}