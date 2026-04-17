<?php

declare(strict_types=1);

/**
 * File-backed rate limiter (works across sessions; suitable for IP-keyed login throttling).
 */
final class RateLimiter
{
    private string $dir;

    public function __construct()
    {
        $this->dir = STORAGE_PATH . '/cache';
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0755, true);
        }
    }

    public function tooManyAttempts(string $key, int $maxAttempts = 5, int $decaySeconds = 900): bool
    {
        $data = $this->readBucket($key);
        if ($data === null) {
            return false;
        }
        if (time() >= $data['reset_at']) {
            return false;
        }
        return $data['attempts'] >= $maxAttempts;
    }

    public function hit(string $key, int $decaySeconds = 900): void
    {
        $now = time();
        $data = $this->readBucket($key);
        if ($data === null || $now >= $data['reset_at']) {
            $data = ['attempts' => 1, 'reset_at' => $now + $decaySeconds];
        } else {
            $data['attempts']++;
        }
        $this->writeBucket($key, $data);
    }

    public function clear(string $key): void
    {
        $path = $this->path($key);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    public function availableIn(string $key): int
    {
        $data = $this->readBucket($key);
        if ($data === null) {
            return 0;
        }
        if (time() >= $data['reset_at']) {
            return 0;
        }
        return max(0, $data['reset_at'] - time());
    }

    private function path(string $key): string
    {
        return $this->dir . '/rate_' . hash('sha256', $key) . '.json';
    }

    /**
     * @return array{attempts: int, reset_at: int}|null
     */
    private function readBucket(string $key): ?array
    {
        $path = $this->path($key);
        if (!is_file($path)) {
            return null;
        }
        $raw = file_get_contents($path);
        if ($raw === false) {
            return null;
        }
        $data = json_decode($raw, true);
        if (!is_array($data) || !isset($data['attempts'], $data['reset_at'])) {
            return null;
        }
        return [
            'attempts' => (int) $data['attempts'],
            'reset_at' => (int) $data['reset_at'],
        ];
    }

    /**
     * @param array{attempts: int, reset_at: int} $data
     */
    private function writeBucket(string $key, array $data): void
    {
        file_put_contents(
            $this->path($key),
            json_encode($data) ?: '{}',
            LOCK_EX
        );
    }
}
