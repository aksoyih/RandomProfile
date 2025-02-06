<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Data\LoginCredentials;
use Faker\Factory;

final class LoginCredentialsGenerator implements GeneratorInterface
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('tr_TR');
    }

    public function generate(): LoginCredentials
    {
        $password = $this->generateStrongPassword();
        $salt = $this->generateSalt();
        $hash = password_hash($password . $salt, PASSWORD_BCRYPT);

        return new LoginCredentials(
            username: $this->generateUsername(),
            email: $this->faker->safeEmail(),
            password: $password,
            salt: $salt,
            hash: $hash,
            md5: md5($password . $salt),
            sha1: sha1($password . $salt),
            sha256: $hash,
            createdAt: \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-2 years', '-1 month')),
            updatedAt: \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 month', 'now')),
        );
    }

    private function generateUsername(): string
    {
        $pattern = $this->faker->randomElement([
            '%s_%d',
            '%s.%d',
            '%s%d%s',
        ]);

        return sprintf(
            $pattern,
            $this->faker->firstName,
            random_int(1, 999),
            $this->faker->randomElement(['TR', 'ist', '_tr', ''])
        );
    }

    private function generateStrongPassword(): string
    {
        $length = random_int(12, 16);
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $password;
    }

    private function generateSalt(): string
    {
        return bin2hex(random_bytes(16));
    }
}