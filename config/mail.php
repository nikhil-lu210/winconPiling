<?php

declare(strict_types=1);

/**
 * Mail / SMTP settings — values come from `.env` (see `.env.example`).
 * Edit `.env` for your environment; keep secrets out of version control.
 *
 * Development (Laragon Pro + Mailpit): use MAIL_MAILER=smtp and point SMTP_* at Mailpit
 * (usually host 127.0.0.1, port 1025, no encryption, SMTP_AUTH=0).
 */

define('MAIL_NOTIFY_ENABLED', filter_var(env('MAIL_NOTIFY_ENABLED', '0'), FILTER_VALIDATE_BOOLEAN));
define('MAIL_NOTIFY_SENDER', filter_var(env('MAIL_NOTIFY_SENDER', '1'), FILTER_VALIDATE_BOOLEAN));
define('MAIL_SENDER_SUBJECT', trim((string) env('MAIL_SENDER_SUBJECT', '')));
define('MAIL_NOTIFY_TO', trim((string) env('MAIL_NOTIFY_TO', '')));
define('MAIL_FROM', trim((string) env('MAIL_FROM', '')));
define('MAIL_MAILER', strtolower(trim((string) env('MAIL_MAILER', 'mail'))));
define('SMTP_HOST', trim((string) env('SMTP_HOST', '')));
define('SMTP_PORT', (int) env('SMTP_PORT', '587'));
define('SMTP_USER', (string) env('SMTP_USER', ''));
define('SMTP_PASSWORD', (string) env('SMTP_PASSWORD', ''));
define('SMTP_ENCRYPTION', strtolower(trim((string) env('SMTP_ENCRYPTION', 'tls'))));
define('SMTP_AUTH', filter_var(env('SMTP_AUTH', '1'), FILTER_VALIDATE_BOOLEAN));
