<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Cache\ProfileCache;

final class GeneratorPool
{
    /** @var array<DynamicProfileGenerator> */
    private array $generators;
    private ProfileCache $cache;
    private int $poolSize;

    public function __construct(int $poolSize = 4)
    {
        $this->poolSize = $poolSize;
        $this->cache = new ProfileCache();
        $this->initializePool();
    }

    private function initializePool(): void
    {
        $this->generators = [];
        for ($i = 0; $i < $this->poolSize; $i++) {
            $this->generators[] = new DynamicProfileGenerator([], $this->cache);
        }
    }

    /**
     * @param int $count Number of profiles to generate
     * @param array<string> $fields Optional fields to include
     * @return array<int, array<string, mixed>>
     */
    public function generateBulk(int $count, array $fields = []): array
    {
        if (!empty($fields)) {
            $this->initializeGeneratorsWithFields($fields);
        }
        
        // Calculate chunk size for better memory management
        $chunkSize = min(50, (int)ceil($count / $this->poolSize));
        $profiles = [];
        $remainingCount = $count;
        $generatorIndex = 0;
        
        while ($remainingCount > 0) {
            $currentChunkSize = min($chunkSize, $remainingCount);
            
            // Use generator in round-robin fashion
            $generator = $this->generators[$generatorIndex];
            $chunkProfiles = $generator->generateMultiple($currentChunkSize);
            $profiles = array_merge($profiles, $chunkProfiles);
            
            $remainingCount -= $currentChunkSize;
            $generatorIndex = ($generatorIndex + 1) % $this->poolSize;
            
            // Clear generator's local cache periodically
            if ($remainingCount % 100 === 0) {
                $generator->clearLocalCache();
            }
            
            // Force garbage collection if needed
            if (memory_get_usage() > 67108864) { // 64MB
                gc_collect_cycles();
            }
        }
        
        return $profiles;
    }

    private function initializeGeneratorsWithFields(array $fields): void
    {
        // Reuse existing generators but update their fields
        foreach ($this->generators as $i => $generator) {
            $this->generators[$i] = new DynamicProfileGenerator($fields, $this->cache);
        }
    }

    public function getCache(): ProfileCache
    {
        return $this->cache;
    }
}