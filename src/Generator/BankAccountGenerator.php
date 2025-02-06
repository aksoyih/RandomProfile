<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\BankAccount;
use Faker\Factory;

final class BankAccountGenerator implements GeneratorInterface
{
    private \Faker\Generator $faker;
    private const TURKISH_BANKS = [
        'Türkiye İş Bankası',
        'Ziraat Bankası',
        'Halk Bankası',
        'Vakıfbank',
        'Garanti BBVA',
        'Yapı Kredi',
        'Akbank',
        'QNB Finansbank',
        'Denizbank',
        'TEB'
    ];

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
    }

    public function generate(): BankAccount
    {
        return new BankAccount(
            iban: $this->generateIBAN(),
            bic: $this->faker->swiftBicNumber,
            bank: $this->faker->randomElement(self::TURKISH_BANKS),
            currency: 'TRY',
            balance: $this->faker->randomFloat(2, 0, 100000),
            debt: $this->faker->randomFloat(2, 0, 50000)
        );
    }

    private function generateIBAN(): string
    {
        return sprintf(
            'TR%s%s',
            $this->faker->numerify('##'),
            $this->faker->numerify('#########################')
        );
    }
}