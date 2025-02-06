<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use JsonSerializable;

final class PhoneInfo implements JsonSerializable
{
    public function __construct(
        private readonly string $number,
        private readonly string $deviceOperationSystem,
        private readonly string $device,
        private readonly string $imei,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'number' => $this->number,
            'device_operation_system' => $this->deviceOperationSystem,
            'device' => $this->device,
            'imei' => $this->imei,
        ];
    }
}