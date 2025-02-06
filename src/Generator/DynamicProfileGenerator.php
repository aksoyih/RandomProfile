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
    private const MAX_LOCAL_CACHE_SIZE = 50;
    private const BATCH_SIZE = 10;

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
        
        // Use local cache with size limit
        if (count($this->localCache) >= self::MAX_LOCAL_CACHE_SIZE) {
            array_shift($this->localCache); // Remove oldest entry
        }
        $this->localCache[$tckn] = $fullProfile;
        
        // Add to shared cache
        $this->cache->add($tckn, $fullProfile);
        
        if (empty($this->includedFields)) {
            return $fullProfile;
        }
        
        return $this->filterFields($fullProfile);
    }

    /**
     * @param array<string, mixed> $profile
     * @return array<string, mixed>
     */
    private function filterFields(array $profile): array
    {
        $filteredProfile = [];
        foreach ($this->includedFields as $field) {
            if (isset($profile[$field])) {
                $filteredProfile[$field] = $profile[$field];
            }
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
        
        for ($i = 0; $i < $count; $i += self::BATCH_SIZE) {
            $currentBatchSize = min(self::BATCH_SIZE, $count - $i);
            
            // Pre-allocate array for better memory efficiency
            $batchProfiles = [];
            for ($j = 0; $j < $currentBatchSize; $j++) {
                $batchProfiles[] = $this->generate();
            }
            
            $profiles = [...$profiles, ...$batchProfiles];
            
            // Clear local cache after each batch to prevent memory bloat
            if ($i % 50 === 0) {
                $this->clearLocalCache();
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

    public function clearLocalCache(): void
    {
        $this->localCache = [];
    }
}