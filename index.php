<?php

declare(strict_types=1);

/**
 * Entry point when the web server's document root is the project folder (not /public).
 * For production, you may still point the vhost at /public and use public/index.php only.
 */
require __DIR__ . '/public/index.php';
