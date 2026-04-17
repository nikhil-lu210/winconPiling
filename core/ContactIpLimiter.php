<?php

declare(strict_types=1);

/**
 * File-based rate limiter for contact form: max successful submissions per IP per time window.
 */
final class ContactIpLimiter
{
    private string $dir;

    public function __construct()
    {
        $this->dir = STORAGE_PATH . '/cache';
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0755, true);
        }
    }

    public function tooManyAttempts(string $ip, int $maxAttempts = 3, int $windowSeconds = 3600): bool
    {
        $path = $this->path($ip);
        if (!is_file($path)) {
            return false;
        }
        $raw = file_get_contents($path);
        if ($raw === false) {
            return false;
        }
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            return false;
        }
        $count = (int) ($data['count'] ?? 0);
        $resetAt = (int) ($data['reset_at'] ?? 0);
        if (time() > $resetAt) {
            return false;
        }
        return $count >= $maxAttempts;
    }

    public function recordSuccess(string $ip, int $windowSeconds = 3600): void
    {
        $path = $this->path($ip);
        $now = time();
        $count = 1;
        $resetAt = $now + $windowSeconds;
        if (is_file($path)) {
            $raw = file_get_contents($path);
            $data = is_string($raw) ? json_decode($raw, true) : null;
            if (is_array($data) && isset($data['reset_at']) && $now <= (int) $data['reset_at']) {
                $count = (int) ($data['count'] ?? 0) + 1;
                $resetAt = (int) $data['reset_at'];
            }
        }
        file_put_contents(
            $path,
            json_encode(['count' => $count, 'reset_at' => $resetAt]),
            LOCK_EX
        );
    }

    private function path(string $ip): string
    {
        return $this->dir . '/contact_' . hash('sha256', $ip) . '.json';
    }
}
