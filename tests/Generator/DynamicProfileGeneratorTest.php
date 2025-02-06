<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Tests\Generator;

use Aksoyih\RandomProfile\Generator\DynamicProfileGenerator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DynamicProfileGeneratorTest extends TestCase
{
    private DynamicProfileGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new DynamicProfileGenerator();
    }

    #[Test]
    public function testGenerateWithDefaultFields(): void
    {
        $profile = $this->generator->generate();
        
        $expectedFields = [
            'gender', 'name', 'surname', 'tckn', 'birthdate', 'age', 'email',
            'phone', 'address', 'bankAccount', 'job'
        ];

        foreach ($expectedFields as $field) {
            $this->assertArrayHasKey($field, $profile);
        }
    }

    #[Test]
    public function testGenerateWithSpecificFields(): void
    {
        $fields = ['name', 'surname', 'tckn'];
        $generator = new DynamicProfileGenerator($fields);
        $profile = $generator->generate();

        // Only requested fields should be present
        $this->assertEquals(array_keys($profile), $fields);
        
        // Verify each field has valid data
        $this->assertIsString($profile['name']);
        $this->assertIsString($profile['surname']);
        $this->assertMatchesRegularExpression('/^\d{11}$/', $profile['tckn']);
    }

    #[Test]
    public function testGenerateMultiple(): void
    {
        $count = 5;
        $profiles = $this->generator->generateMultiple($count);

        $this->assertCount($count, $profiles);
        
        // Verify each profile is unique
        $tckns = array_column($profiles, 'tckn');
        $uniqueTckns = array_unique($tckns);
        $this->assertCount($count, $uniqueTckns);
    }

    #[Test]
    public function testCacheIntegration(): void
    {
        $fields = ['name', 'tckn'];
        $generator = new DynamicProfileGenerator($fields);
        
        // Generate a profile and get its TCKN
        $profile = $generator->generate();
        $tckn = $profile['tckn'];
        
        // Verify the profile is in cache
        $cachedProfile = $generator->getCache()->get($tckn);
        $this->assertNotNull($cachedProfile);
        
        // The cached version should be the full profile
        $this->assertGreaterThan(
            count($fields),
            count($cachedProfile)
        );
    }
}