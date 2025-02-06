<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Cache;

final class ProfileCache
{
    /** @var array<string, array<string, mixed>> */
    private array $cache = [];
    private int $maxSize;

    public function __construct(int $maxSize = 1000)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @param array<string, mixed> $profile
     */
    public function add(string $tckn, array $profile): void
    {
        if (count($this->cache) >= $this->maxSize) {
            array_shift($this->cache); // Remove oldest entry
        }
        $this->cache[$tckn] = $profile;
    }

    public function get(string $tckn): ?array
    {
        return $this->cache[$tckn] ?? null;
    }

    public function clear(): void
    {
        $this->cache = [];
    }
}