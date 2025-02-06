<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Factory;

use Aksoyih\RandomProfile\Cache\ProfileCache;
use Aksoyih\RandomProfile\Generator\DynamicProfileGenerator;
use Aksoyih\RandomProfile\Generator\GeneratorPool;
use Aksoyih\RandomProfile\Generator\ProfileGenerator;

final class RandomProfileFactory
{
    private ProfileGenerator $generator;
    private GeneratorPool $pool;
    private ProfileCache $cache;
    private int $batchThreshold;

    public function __construct(int $poolSize = 4, int $batchThreshold = 10)
    {
        $this->cache = new ProfileCache();
        $this->generator = new ProfileGenerator();
        $this->pool = new GeneratorPool($poolSize);
        $this->batchThreshold = $batchThreshold;
    }

    /**
     * Generate a single random profile
     * 
     * @param array<string> $fields Optional specific fields to include
     * @return array<string, mixed>
     */
    public function generate(array $fields = []): array
    {
        if (empty($fields)) {
            return $this->generator->generate()->jsonSerialize();
        }

        $dynamicGenerator = new DynamicProfileGenerator($fields, $this->cache);
        return $dynamicGenerator->generate();
    }

    /**
     * Generate multiple random profiles optimally
     * 
     * @param int $count Number of profiles to generate
     * @param array<string> $fields Optional specific fields to include
     * @param bool $usePool Whether to use the generator pool for parallel generation
     * @return array<int, array<string, mixed>>
     */
    public function generateMultiple(
        int $count,
        array $fields = [],
        bool $usePool = true
    ): array {
        // Use pool for larger batches
        if ($usePool && $count > $this->batchThreshold) {
            return $this->pool->generateBulk($count, $fields);
        }

        // Use optimized dynamic generator for smaller batches
        $dynamicGenerator = new DynamicProfileGenerator($fields, $this->cache);
        $result = $dynamicGenerator->generateMultiple($count);
        
        // Clean up after generation
        $dynamicGenerator->clearLocalCache();
        
        if (memory_get_usage() > 67108864) { // 64MB
            gc_collect_cycles();
        }

        return $result;
    }

    /**
     * Get the current cache instance
     */
    public function getCache(): ProfileCache
    {
        return $this->cache;
    }

    /**
     * Clear all caches (both shared and local)
     */
    public function clearCache(): void
    {
        $this->cache->clear();
    }

    /**
     * Configure the batch threshold for pool usage
     */
    public function setBatchThreshold(int $threshold): void
    {
        $this->batchThreshold = $threshold;
    }
}