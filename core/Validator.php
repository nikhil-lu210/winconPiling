<?php

declare(strict_types=1);

final class Validator
{
    /** @var array<string, string> */
    public array $errors = [];

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $rules field => "required|email|min:3|max:100|numeric|in:a,b|url|image_ext"
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];
        foreach ($rules as $field => $ruleString) {
            $parts = array_map('trim', explode('|', $ruleString));
            $value = $data[$field] ?? null;

            foreach ($parts as $rule) {
                if ($rule === '') {
                    continue;
                }
                if ($rule === 'required') {
                    if ($value === null || $value === '' || (is_array($value) && $value === [])) {
                        $this->errors[$field] = 'The ' . $field . ' field is required.';
                        break;
                    }
                    continue;
                }
                if (($value === null || $value === '') && !in_array('required', $parts, true)) {
                    continue;
                }

                if ($rule === 'email' && is_string($value) && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field] = 'The ' . $field . ' must be a valid email.';
                    break;
                }
                if (str_starts_with($rule, 'min:')) {
                    $n = (int) substr($rule, 4);
                    if (is_string($value) && mb_strlen($value) < $n) {
                        $this->errors[$field] = 'The ' . $field . ' must be at least ' . $n . ' characters.';
                        break;
                    }
                }
                if (str_starts_with($rule, 'max:')) {
                    $n = (int) substr($rule, 4);
                    if (is_string($value) && mb_strlen($value) > $n) {
                        $this->errors[$field] = 'The ' . $field . ' may not be greater than ' . $n . ' characters.';
                        break;
                    }
                }
                if ($rule === 'numeric' && $value !== null && $value !== '' && !is_numeric($value)) {
                    $this->errors[$field] = 'The ' . $field . ' must be numeric.';
                    break;
                }
                if (str_starts_with($rule, 'in:')) {
                    $opts = array_map('trim', explode(',', substr($rule, 3)));
                    if (!in_array((string) $value, $opts, true)) {
                        $this->errors[$field] = 'The selected ' . $field . ' is invalid.';
                        break;
                    }
                }
                if ($rule === 'url' && is_string($value) && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $this->errors[$field] = 'The ' . $field . ' must be a valid URL.';
                    break;
                }
                if ($rule === 'image_ext' && is_string($value) && $value !== '') {
                    $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
                        $this->errors[$field] = 'The ' . $field . ' must be a valid image extension.';
                        break;
                    }
                }
                if ($rule === 'youtube_id' && (!is_string($value) || !preg_match('/^[a-zA-Z0-9_-]{11}$/', $value))) {
                    $this->errors[$field] = 'The ' . $field . ' must be a valid 11-character YouTube video ID.';
                    break;
                }
                if ($rule === 'slug' && (!is_string($value) || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value))) {
                    $this->errors[$field] = 'The ' . $field . ' must be lowercase letters, numbers, and hyphens only.';
                    break;
                }
            }
        }
        return $this->errors === [];
    }

    /**
     * @return array<string, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getError(string $field): ?string
    {
        return $this->errors[$field] ?? null;
    }

    public function passes(): bool
    {
        return $this->errors === [];
    }

    public function fails(): bool
    {
        return $this->errors !== [];
    }
}
