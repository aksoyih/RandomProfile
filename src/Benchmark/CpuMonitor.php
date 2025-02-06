<?php

declare(strict_types=1);

namespace Aksoyih\RandomProfile\Benchmark;

final class CpuMonitor
{
    private float $startTime;
    private array $startUsage;

    public function start(): void
    {
        $this->startTime = microtime(true);
        $this->startUsage = getrusage();
    }

    public function getMetrics(): array
    {
        $endTime = microtime(true);
        $endUsage = getrusage();

        $userTime = ($endUsage['ru_utime.tv_sec'] + $endUsage['ru_utime.tv_usec'] / 1000000)
                 - ($this->startUsage['ru_utime.tv_sec'] + $this->startUsage['ru_utime.tv_usec'] / 1000000);
        
        $systemTime = ($endUsage['ru_stime.tv_sec'] + $endUsage['ru_stime.tv_usec'] / 1000000)
                   - ($this->startUsage['ru_stime.tv_sec'] + $this->startUsage['ru_stime.tv_usec'] / 1000000);

        $wallTime = $endTime - $this->startTime;

        return [
            'wall_time' => $wallTime,
            'user_time' => $userTime,
            'system_time' => $systemTime,
            'cpu_usage' => ($userTime + $systemTime) / $wallTime * 100,
            'voluntary_switches' => $endUsage['ru_nvcsw'] - $this->startUsage['ru_nvcsw'],
            'involuntary_switches' => $endUsage['ru_nivcsw'] - $this->startUsage['ru_nivcsw'],
        ];
    }
}