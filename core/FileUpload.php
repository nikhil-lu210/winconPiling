<?php

declare(strict_types=1);

final class FileUpload
{
    /**
     * @param array<string, mixed> $file single $_FILES entry
     * @param array{maxSize?: int, allowedTypes?: array<int, string>, prefix?: string} $options
     */
    public function handle(array $file, string $destination, array $options = []): string|false
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }
        $tmp = $file['tmp_name'] ?? null;
        if (!is_string($tmp) || !is_uploaded_file($tmp)) {
            return false;
        }

        $maxSize = $options['maxSize'] ?? UPLOAD_MAX_SIZE;
        $size = (int) ($file['size'] ?? 0);
        if ($size > $maxSize) {
            return false;
        }

        $origName = (string) ($file['name'] ?? 'file');
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        if ($ext === '' || preg_match('/[^a-z0-9]/', $ext)) {
            return false;
        }

        $allowed = $options['allowedTypes'] ?? array_map('trim', explode(',', ALLOWED_IMAGE_TYPES));
        if (!$this->validateMime($tmp, $allowed)) {
            return false;
        }

        if (!is_dir($destination) && !mkdir($destination, 0755, true) && !is_dir($destination)) {
            return false;
        }

        $prefix = isset($options['prefix']) ? (string) $options['prefix'] : '';
        $safeBase = bin2hex(random_bytes(8));
        $newName = $prefix . uniqid('', true) . '_' . $safeBase . '.' . $ext;
        $newName = $this->sanitizeFilename($newName);
        $fullPath = rtrim($destination, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newName;

        if (!move_uploaded_file($tmp, $fullPath)) {
            return false;
        }

        $publicUpload = realpath(ROOT_PATH . '/public/assets/uploads');
        $realFull = realpath($fullPath);
        if ($publicUpload === false || $realFull === false || !str_starts_with($realFull, $publicUpload)) {
            return false;
        }

        $rel = str_replace('\\', '/', substr($realFull, strlen($publicUpload) + 1));
        return $rel;
    }

    /**
     * @param array<int, string> $allowedMimes
     */
    private function validateMime(string $tmpPath, array $allowedMimes): bool
    {
        if (!function_exists('finfo_open')) {
            return false;
        }
        $f = finfo_open(FILEINFO_MIME_TYPE);
        if ($f === false) {
            return false;
        }
        $mime = finfo_file($f, $tmpPath);
        finfo_close($f);
        if (!is_string($mime)) {
            return false;
        }
        return in_array($mime, $allowedMimes, true);
    }

    private function sanitizeFilename(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9._-]/', '_', $name) ?? $name;
    }
}
