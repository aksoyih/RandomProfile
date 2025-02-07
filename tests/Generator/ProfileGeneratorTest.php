<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Tests\Generator;

use Aksoyih\RandomProfile\Generator\ProfileGenerator;
use Aksoyih\RandomProfile\Data\Profile;
use Aksoyih\RandomProfile\Enum\Gender;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfileGeneratorTest extends TestCase
{
    private ProfileGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new ProfileGenerator();
    }

    #[Test]
    public function testGenerateReturnsProfileInstance(): void
    {
        $profile = $this->generator->generate();
        
        $this->assertInstanceOf(Profile::class, $profile);
    }

    #[Test]
    public function testGenerateWithSpecificGender(): void
    {
        $maleProfile = $this->generator->generate('male');
        $femaleProfile = $this->generator->generate('female');
        
        $this->assertEquals('male', $maleProfile->jsonSerialize()['gender']);
        $this->assertEquals('female', $femaleProfile->jsonSerialize()['gender']);
        
        // Test that spouse gender is opposite
        $this->assertEquals('female', $maleProfile->jsonSerialize()['maritalInfo']['spouse']['gender'] ?? null);
        $this->assertEquals('male', $femaleProfile->jsonSerialize()['maritalInfo']['spouse']['gender'] ?? null);
    }

    #[Test]
    public function testGeneratedProfileHasValidData(): void
    {
        $profile = $this->generator->generate()->jsonSerialize();

        // Test basic profile properties
        $this->assertContains($profile['gender'], ['male', 'female']);
        $this->assertIsString($profile['name']);
        $this->assertIsString($profile['surname']);
        $this->assertMatchesRegularExpression('/^\d{11}$/', $profile['tckn']);
        $this->assertIsString($profile['serialNumber']);
        $this->assertMatchesRegularExpression('/^[A-Z0-9]{9}$/', $profile['serialNumber']);
        $this->assertIsString($profile['birthdate']);
        $this->assertIsInt($profile['age']);
        $this->assertGreaterThanOrEqual(18, $profile['age']);
        $this->assertLessThanOrEqual(80, $profile['age']);
        $this->assertIsString($profile['email']);
        $this->assertEmailIsValid($profile['email']);
        
        // Test complex objects after serialization
        $phone = $profile['phone'];
        $this->assertIsArray($phone);
        $this->assertArrayHasKey('number', $phone);
        $this->assertArrayHasKey('device', $phone);
        $this->assertArrayHasKey('device_operation_system', $phone);

        $this->assertIsArray($profile['address']);
        $this->assertIsArray($profile['bankAccount']);
        $this->assertIsArray($profile['job']);
        $this->assertIsArray($profile['loginCredentials']);
    }

    #[Test]
    public function testGeneratedProfilesAreUnique(): void
    {
        $profile1 = $this->generator->generate()->jsonSerialize();
        $profile2 = $this->generator->generate()->jsonSerialize();

        $this->assertNotEquals($profile1['tckn'], $profile2['tckn']);
        $this->assertNotEquals($profile1['serialNumber'], $profile2['serialNumber']);
    }

    private function assertEmailIsValid(string $email): void
    {
        $this->assertMatchesRegularExpression('/^[^@]+@[^@]+\.[^@]+$/', $email);
    }
}