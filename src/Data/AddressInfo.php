<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Data;

use JsonSerializable;

final class AddressInfo implements JsonSerializable
{
    public function __construct(
        private readonly string $fullAddress,
        private readonly string $city,
        private readonly string $district,
        private readonly string $street,
        private readonly int $apartmentNumber,
        private readonly int $postalCode,
        private readonly array $timeZone,
        private readonly Coordinates $coordinates,
    ) {
    }

    public function getOpenStreetMapLink(): string
    {
        return sprintf(
            'https://www.openstreetmap.org/?mlat=%s&mlon=%s',
            $this->coordinates->jsonSerialize()['latitute'],
            $this->coordinates->jsonSerialize()['longitute']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'fullAddress' => $this->fullAddress,
            'city' => $this->city,
            'district' => $this->district,
            'street' => $this->street,
            'apartmentNumber' => $this->apartmentNumber,
            'postalCode' => $this->postalCode,
            'timeZone' => $this->timeZone,
            'coordinates' => $this->coordinates,
            'openstreetmap_link' => $this->getOpenStreetMapLink(),
        ];
    }
}