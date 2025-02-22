<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Tests\Factory;

use Aksoyih\RandomProfile\Factory\RandomProfileFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RandomProfileFactoryTest extends TestCase
{
    private RandomProfileFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new RandomProfileFactory();
    }

    public function testGenerateSingleProfile(): void
    {
        $profile = $this->factory->generate();

        $this->assertIsArray($profile);
        $this->assertArrayHasKey('name', $profile);
        $this->assertArrayHasKey('surname', $profile);
        $this->assertArrayHasKey('tckn', $profile);
    }

    public function testGenerateWithSpecificGender(): void
    {
        $maleProfile = $this->factory->generate([], 'male');
        $femaleProfile = $this->factory->generate([], 'female');

        $this->assertEquals('male', $maleProfile['gender']);
        $this->assertEquals('female', $femaleProfile['gender']);
    }

    public function testGenerateMultipleProfiles(): void
    {
        $count = 5;
        $profiles = $this->factory->generateMultiple($count);

        $this->assertCount($count, $profiles);
        $this->assertIsArray($profiles[0]);
        
        // Ensure profiles are unique
        $tckns = array_column($profiles, 'tckn');
        $uniqueTckns = array_unique($tckns);
        $this->assertCount($count, $uniqueTckns);
    }

    public function testGenerateMultipleProfilesWithGender(): void
    {
        $count = 5;
        $maleProfiles = $this->factory->generateMultiple($count, [], 'male');
        $femaleProfiles = $this->factory->generateMultiple($count, [], 'female');

        $this->assertCount($count, $maleProfiles);
        $this->assertCount($count, $femaleProfiles);

        foreach ($maleProfiles as $profile) {
            $this->assertEquals('male', $profile['gender']);
        }

        foreach ($femaleProfiles as $profile) {
            $this->assertEquals('female', $profile['gender']);
        }
    }

    public function testGeneratedProfileMatchesSchema(): void
    {
        $profile = $this->factory->generate();
        
        // Test required top-level fields
        $requiredFields = [
            'gender', 'name', 'surname', 'tckn', 'serialNumber',
            'birthdate', 'age', 'email', 'phone', 'address',
            'bankAccount', 'loginCredentials', 'images'
        ];

        foreach ($requiredFields as $field) {
            $this->assertArrayHasKey($field, $profile);
        }

        // Test nested structures after serialization
        $phone = $profile['phone'];
        $this->assertIsArray($phone);
        $this->assertArrayHasKey('number', $phone);
        $this->assertArrayHasKey('device', $phone);
        $this->assertArrayHasKey('device_operation_system', $phone);

        $address = $profile['address'];
        $this->assertIsArray($address);
        $this->assertArrayHasKey('city', $address);
        $this->assertArrayHasKey('coordinates', $address);
    }
}