<?php

declare(strict_types=1);

/**
 * Ensure log directory exists and route PHP errors + uncaught exceptions to storage/logs/app.log.
 */
if (!is_dir(STORAGE_PATH . '/logs')) {
    @mkdir(STORAGE_PATH . '/logs', 0755, true);
}

ini_set('log_errors', '1');
ini_set('error_log', STORAGE_PATH . '/logs/app.log');

set_exception_handler(static function (\Throwable $e): void {
    log_error($e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);
    if (!defined('APP_DEBUG') || !APP_DEBUG) {
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
        $view = APP_PATH . '/Views/errors/500.php';
        if (is_file($view)) {
            $errorMessage = '';
            include $view;
        } else {
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Server error</title></head><body><p>An error occurred.</p></body></html>';
        }
        exit;
    }
    http_response_code(500);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Exception</title></head><body><pre>'
        . htmlspecialchars($e->getMessage() . "\n\n" . $e->getTraceAsString(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
        . '</pre></body></html>';
    exit;
});

set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    log_error($message, ['file' => $file, 'line' => $line, 'severity' => $severity]);
    return false;
});

register_shutdown_function(static function (): void {
    $err = error_get_last();
    if ($err === null || !in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        return;
    }
    log_error($err['message'], ['file' => $err['file'], 'line' => $err['line'], 'type' => $err['type']]);
});
