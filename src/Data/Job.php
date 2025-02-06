<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use DateTimeImmutable;
use JsonSerializable;

final class Job implements JsonSerializable
{
    public function __construct(
        private readonly string $workingStatus,
        private readonly string $company,
        private readonly string $position,
        private readonly DateTimeImmutable $startDate,
        private readonly ?DateTimeImmutable $endDate,
        private readonly int $experience,
        private readonly array $salary,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'workingStatus' => $this->workingStatus,
            'company' => $this->company,
            'position' => $this->position,
            'startDate' => $this->startDate->format('Y-m-d'),
            'endDate' => $this->endDate?->format('Y-m-d'),
            'experience' => $this->experience,
            'salary' => $this->salary,
        ];
    }
}