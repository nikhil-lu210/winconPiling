<?php

declare(strict_types=1);

final class RateLimiter
{
    private const SESSION_PREFIX = '_rate_limit_';

    public function tooManyAttempts(string $key, int $maxAttempts = 5, int $decaySeconds = 900): bool
    {
        $data = $this->getBucket($key);
        if ($data === null) {
            return false;
        }
        if (time() >= $data['reset_at']) {
            return false;
        }
        return $data['attempts'] >= $maxAttempts;
    }

    public function hit(string $key): void
    {
        $now = time();
        $data = $this->getBucket($key);
        if ($data === null || $now >= $data['reset_at']) {
            $data = ['attempts' => 1, 'reset_at' => $now + 900];
        } else {
            $data['attempts']++;
        }
        Session::set(self::SESSION_PREFIX . $key, $data);
    }

    public function clear(string $key): void
    {
        Session::delete(self::SESSION_PREFIX . $key);
    }

    public function availableIn(string $key): int
    {
        $data = $this->getBucket($key);
        if ($data === null) {
            return 0;
        }
        $left = $data['reset_at'] - time();
        return max(0, $left);
    }

    /**
     * @return array{attempts: int, reset_at: int}|null
     */
    private function getBucket(string $key): ?array
    {
        $v = Session::get(self::SESSION_PREFIX . $key);
        if (!is_array($v) || !isset($v['attempts'], $v['reset_at'])) {
            return null;
        }
        return [
            'attempts' => (int) $v['attempts'],
            'reset_at' => (int) $v['reset_at'],
        ];
    }
}
