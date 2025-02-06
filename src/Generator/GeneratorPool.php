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
        
        // Calculate optimal batch size based on pool size
        $batchSize = (int)ceil($count / $this->poolSize);
        $profiles = [];
        
        // Generate profiles in parallel batches
        for ($i = 0; $i < $this->poolSize; $i++) {
            $start = $i * $batchSize;
            $currentBatchSize = min($batchSize, $count - $start);
            
            if ($currentBatchSize <= 0) {
                break;
            }
            
            $generator = $this->generators[$i];
            $batchProfiles = $generator->generateMultiple($currentBatchSize);
            $profiles = array_merge($profiles, $batchProfiles);
        }
        
        return array_slice($profiles, 0, $count);
    }

    private function initializeGeneratorsWithFields(array $fields): void
    {
        $this->generators = array_map(
            fn() => new DynamicProfileGenerator($fields, $this->cache),
            range(1, $this->poolSize)
        );
    }

    public function getCache(): ProfileCache
    {
        return $this->cache;
    }
}