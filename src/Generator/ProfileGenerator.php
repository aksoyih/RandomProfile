<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\Profile;
use Aksoyih\RandomProfile\Enum\Gender;
use Aksoyih\RandomProfile\Validator\TcknValidator;
use DateTime;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

final class ProfileGenerator implements GeneratorInterface
{
    private Generator $faker;
    private AddressGenerator $addressGenerator;
    private BankAccountGenerator $bankAccountGenerator;
    private LoginCredentialsGenerator $loginCredentialsGenerator;
    private PhoneInfoGenerator $phoneInfoGenerator;
    private JobGenerator $jobGenerator;

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
        $this->addressGenerator = new AddressGenerator();
        $this->bankAccountGenerator = new BankAccountGenerator();
        $this->loginCredentialsGenerator = new LoginCredentialsGenerator();
        $this->phoneInfoGenerator = new PhoneInfoGenerator();
        $this->jobGenerator = new JobGenerator();
    }

    public function generate(?string $gender = null): Profile
    {
        $gender = $gender ?? $this->faker->randomElement(['male', 'female']);
        $name = $gender === 'male' ? $this->faker->firstNameMale : $this->faker->firstNameFemale;
        $birthDate = $this->faker->dateTimeBetween('-80 years', '-18 years');

        return new Profile(
            gender: Gender::from($gender),
            name: $name,
            surname: $this->faker->lastName,
            tckn: TcknValidator::generate(),
            serialNumber: $this->faker->regexify('[A-Z0-9]{9}'),
            birthdate: DateTimeImmutable::createFromMutable($birthDate),
            age: (int) $birthDate->diff(new DateTime())->y,
            titles: ['academic_title' => null],
            email: $this->faker->safeEmail,
            phone: $this->phoneInfoGenerator->generate(),
            loginCredentials: $this->loginCredentialsGenerator->generate(),
            miscellaneous: $this->generateMiscellaneous(),
            networkInfo: $this->generateNetworkInfo(),
            maritalInfo: $this->generateMaritalInfo($gender),
            children: $this->generateChildren(),
            address: $this->addressGenerator->generate(),
            bankAccount: $this->bankAccountGenerator->generate(),
            images: $this->generateImages($gender),
            job: $this->jobGenerator->generate(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function generateMiscellaneous(): array
    {
        return [
            'favorite_emojis' => $this->faker->randomElements(['😊', '😂', '🤣', '❤️', '😍', '😒', '😡'], 2),
            'language_code' => $this->faker->languageCode,
            'country_code' => 'TR',
            'locale_data' => $this->faker->locale,
            'currency_code' => 'TRY',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function generateNetworkInfo(): array
    {
        return [
            'ipv_4' => $this->faker->ipv4,
            'ipv_6' => $this->faker->ipv6,
            'mac_address' => $this->faker->macAddress,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function generateMaritalInfo(string $gender): array
    {
        $isMarried = $this->faker->boolean(70);
        if (!$isMarried) {
            return ['status' => 'single'];
        }

        return [
            'status' => 'married',
            'marriage_date' => $this->faker->date(),
            'marriedFor' => random_int(1, 40),
            'spouse' => $this->generateSpouse($gender),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function generateSpouse(string $gender): array
    {
        // Generate opposite gender for spouse
        $spouseGender = $gender === 'male' ? 'female' : 'male';
        $name = $spouseGender === 'male' ? $this->faker->firstNameMale : $this->faker->firstNameFemale;
        
        return [
            'gender' => $spouseGender,
            'name' => $name,
            'surname' => $this->faker->lastName,
            'tckn' => TcknValidator::generate(),
            'serialNumber' => $this->faker->regexify('[A-Z0-9]{9}'),
            'birthdate' => $this->faker->date(),
            'age' => random_int(20, 80),
            'email' => $this->faker->safeEmail,
            'phone' => $this->phoneInfoGenerator->generate(),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function generateChildren(): array
    {
        $hasChildren = $this->faker->boolean(60);
        if (!$hasChildren) {
            return [];
        }

        $childrenCount = random_int(1, 4);
        $children = [];
        
        for ($i = 0; $i < $childrenCount; $i++) {
            $gender = $this->faker->randomElement(['male', 'female']);
            $name = $gender === 'male' ? $this->faker->firstNameMale : $this->faker->firstNameFemale;
            $birthDate = $this->faker->dateTimeBetween('-30 years', '-1 year');

            $children[] = [
                'gender' => $gender,
                'name' => $name,
                'surname' => $this->faker->lastName,
                'tckn' => TcknValidator::generate(),
                'serialNumber' => $this->faker->regexify('[A-Z0-9]{9}'),
                'birthdate' => $birthDate->format('Y-m-d'),
                'age' => (int) $birthDate->diff(new DateTime())->y,
                'email' => $this->faker->safeEmail,
                'phone' => $this->phoneInfoGenerator->generate(),
                'address' => $this->addressGenerator->generate(),
            ];
        }

        return $children;
    }

    /**
     * @return array<string, string>
     */
    private function generateImages(string $gender): array
    {
        $name = strtolower($this->faker->firstName);
        return [
            'avatar' => "https://avatars.dicebear.com/api/personas/{$name}.jpg",
            'profile_picture' => "https://xsgames.co/randomusers/avatar.php?g={$gender}",
            'pixel_art' => "https://xsgames.co/randomusers/avatar.php?g=pixel",
        ];
    }
}