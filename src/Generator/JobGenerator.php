<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\Job;
use Faker\Factory;
use Faker\Generator;

final class JobGenerator implements GeneratorInterface
{
    private Generator $faker;
    private const TURKISH_JOB_TITLES = [
        'Yazılım Mühendisi',
        'Öğretmen',
        'Doktor',
        'Avukat',
        'Muhasebeci',
        'Satış Temsilcisi',
        'Mimar',
        'Grafik Tasarımcı',
        'İnsan Kaynakları Uzmanı',
        'Pazarlama Müdürü',
        'Aşçı',
        'Elektrik Teknisyeni',
        'Hemşire',
        'Bankacı',
        'Garson',
    ];

    private const TURKISH_COMPANY_SUFFIXES = [
        'A.Ş.',
        'Ltd. Şti.',
        'Holding',
        'Grup',
    ];

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
    }

    public function generate(): Job
    {
        $startDate = $this->faker->dateTimeBetween('-20 years', '-1 month');
        $isCurrentlyWorking = $this->faker->boolean(80);
        $endDate = $isCurrentlyWorking ? null : 
            \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween($startDate, 'now'));

        $monthlySalary = $this->faker->numberBetween(11500, 100000);

        return new Job(
            workingStatus: $isCurrentlyWorking ? 'working' : 'not_working',
            company: $this->generateCompanyName(),
            position: $this->faker->randomElement(self::TURKISH_JOB_TITLES),
            startDate: \DateTimeImmutable::createFromMutable($startDate),
            endDate: $endDate,
            experience: $startDate->diff(new \DateTime())->y,
            salary: [
                'monthly' => $monthlySalary,
                'annually' => $monthlySalary * 12,
            ],
        );
    }

    private function generateCompanyName(): string
    {
        return sprintf(
            '%s %s',
            $this->faker->company,
            $this->faker->randomElement(self::TURKISH_COMPANY_SUFFIXES)
        );
    }
}