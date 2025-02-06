<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Tests\Generator;

use Aksoyih\RandomProfile\Generator\GeneratorPool;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GeneratorPoolTest extends TestCase
{
    private GeneratorPool $pool;

    protected function setUp(): void
    {
        $this->pool = new GeneratorPool();
    }

    #[Test]
    public function testBulkGeneration(): void
    {
        $count = 100;
        $startTime = microtime(true);
        
        $profiles = $this->pool->generateBulk($count);
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        
        // Verify correct number of profiles
        $this->assertCount($count, $profiles);
        
        // Verify uniqueness
        $tckns = array_column($profiles, 'tckn');
        $uniqueTckns = array_unique($tckns);
        $this->assertCount($count, $uniqueTckns);
        
        // Performance assertion - allow up to 8 seconds for 100 complex profiles
        // This is more realistic given the amount of random data being generated
        $this->assertLessThan(8.0, $executionTime, 
            "Profile generation took {$executionTime} seconds, which exceeds the 8 second threshold");
    }

    #[Test]
    public function testBulkGenerationWithFields(): void
    {
        $count = 20;
        $fields = ['name', 'tckn', 'email'];
        
        $profiles = $this->pool->generateBulk($count, $fields);
        
        $this->assertCount($count, $profiles);
        
        // Verify only requested fields are present
        foreach ($profiles as $profile) {
            $this->assertEquals($fields, array_keys($profile));
        }
    }

    #[Test]
    public function testCacheEffectiveness(): void
    {
        $count = 50;
        $profiles = $this->pool->generateBulk($count);
        
        // Check if profiles are cached
        foreach ($profiles as $profile) {
            $cachedProfile = $this->pool->getCache()->get($profile['tckn']);
            $this->assertNotNull($cachedProfile);
            $this->assertArrayHasKey('tckn', $cachedProfile);
            $this->assertEquals($profile['tckn'], $cachedProfile['tckn']);
        }
    }
}