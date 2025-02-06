<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\AddressInfo;
use Aksoyih\RandomProfile\Data\Coordinates;
use Faker\Factory;

final class AddressGenerator implements GeneratorInterface
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
    }

    public function generate(): AddressInfo
    {
        $city = $this->faker->city;
        $district = $this->faker->randomElement(['Merkez', 'Taşköprü', 'Tosya', 'İnebolu']);
        $street = $this->faker->streetName;
        $apartmentNumber = random_int(1, 200);
        
        $coordinates = new Coordinates(
            latitude: (string) $this->faker->latitude(36, 42),
            longitude: (string) $this->faker->longitude(26, 45)
        );

        return new AddressInfo(
            fullAddress: sprintf('%s %s No: %d / %s', $street, $district, $apartmentNumber, $city),
            city: $city,
            district: $district,
            street: $street,
            apartmentNumber: $apartmentNumber,
            postalCode: random_int(10000, 81000),
            timeZone: [
                'timeZone' => 'Europe/Istanbul',
                'time' => (new \DateTime())->format('H:i:s')
            ],
            coordinates: $coordinates
        );
    }
}