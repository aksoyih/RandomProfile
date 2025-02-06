<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Generator;

use Aksoyih\RandomProfile\Cache\ProfileCache;

final class DynamicProfileGenerator implements GeneratorInterface
{
    private ProfileGenerator $baseGenerator;
    /** @var array<string> */
    private array $includedFields;
    private ProfileCache $cache;
    /** @var array<string, array<string, mixed>> */
    private array $localCache = [];

    /**
     * @param array<string> $includedFields List of fields to include in the generated profile
     */
    public function __construct(
        array $includedFields = [],
        ?ProfileCache $cache = null
    ) {
        $this->baseGenerator = new ProfileGenerator();
        $this->includedFields = $includedFields ?: [
            'gender', 'name', 'surname', 'tckn', 'birthdate', 'age', 'email',
            'phone', 'address', 'bankAccount', 'job'
        ];
        $this->cache = $cache ?? new ProfileCache();
    }

    public function generate(): array
    {
        $fullProfile = $this->baseGenerator->generate()->jsonSerialize();
        $tckn = $fullProfile['tckn'];
        
        // Use local cache first for better performance
        $this->localCache[$tckn] = $fullProfile;
        
        // Add to shared cache if available
        if ($this->cache) {
            $this->cache->add($tckn, $fullProfile);
        }
        
        if (empty($this->includedFields)) {
            return $fullProfile;
        }
        
        // Return fields in the specified order
        $filteredProfile = [];
        foreach ($this->includedFields as $field) {
            if (isset($fullProfile[$field])) {
                $filteredProfile[$field] = $fullProfile[$field];
            }
        }
        
        // Clear local cache if it gets too large
        if (count($this->localCache) > 100) {
            $this->localCache = [];
        }
        return $filteredProfile;
    }

    /**
     * Optimized bulk generation method
     * 
     * @param int $count Number of profiles to generate
     * @return array<int, array<string, mixed>>
     */
    public function generateMultiple(int $count): array
    {
        $profiles = [];
        $batchSize = 20; // Process in smaller batches to manage memory

        for ($i = 0; $i < $count; $i += $batchSize) {
            $currentBatchSize = min($batchSize, $count - $i);
            
            $batchProfiles = array_map(
                fn() => $this->generate(),
                range(1, $currentBatchSize)
            );
            
            $profiles = [...$profiles, ...$batchProfiles];
            
            // Clear local cache after each batch
            $this->localCache = [];
            
            // Trigger garbage collection if memory usage is high
            if (memory_get_usage() > 67108864) { // 64MB
                gc_collect_cycles();
            }
        }

        return $profiles;
    }

    /**
     * @return array<string>
     */
    public function getIncludedFields(): array
    {
        return $this->includedFields;
    }

    public function getCache(): ProfileCache
    {
        return $this->cache;
    }

    /**
     * Clear local cache manually if needed
     */
    public function clearLocalCache(): void
    {
        $this->localCache = [];
    }
}