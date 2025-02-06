<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\PhoneInfo;
use Faker\Factory;

final class PhoneInfoGenerator implements GeneratorInterface
{
    private \Faker\Generator $faker;
    private const DEVICES = [
        'iOS' => [
            'Apple iPhone 12',
            'Apple iPhone 13',
            'Apple iPhone 14',
            'Apple iPhone 14 Pro',
            'Apple iPhone SE 2022',
        ],
        'Android' => [
            'Samsung Galaxy S21',
            'Samsung Galaxy S22',
            'Samsung Galaxy A53',
            'Xiaomi Redmi Note 11',
            'OnePlus 10 Pro',
        ],
    ];

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
    }

    public function generate(): PhoneInfo
    {
        $os = $this->faker->randomElement(['iOS', 'Android']);
        
        return new PhoneInfo(
            number: $this->generateTurkishPhoneNumber(),
            deviceOperationSystem: $os,
            device: $this->faker->randomElement(self::DEVICES[$os]),
            imei: $this->generateIMEI()
        );
    }

    private function generateTurkishPhoneNumber(): string
    {
        return sprintf(
            '05%d%d%d%d%d%d%d%d%d',
            random_int(3, 5),
            ...array_map(fn() => random_int(0, 9), range(1, 8))
        );
    }

    private function generateIMEI(): string
    {
        $imei = '';
        for ($i = 0; $i < 14; $i++) {
            $imei .= random_int(0, 9);
        }
        
        // Calculate check digit (Luhn algorithm)
        $sum = 0;
        for ($i = 0; $i < 14; $i++) {
            $d = (int) $imei[$i];
            if ($i % 2 == 1) {
                $d *= 2;
                if ($d > 9) {
                    $d -= 9;
                }
            }
            $sum += $d;
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        
        return $imei . $checkDigit;
    }
}