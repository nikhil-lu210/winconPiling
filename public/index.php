<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('CORE_PATH', ROOT_PATH . '/core');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('STORAGE_PATH', ROOT_PATH . '/storage');

require_once CONFIG_PATH . '/app.php';
require_once CORE_PATH . '/helpers.php';
require_once CORE_PATH . '/Database.php';
require_once CORE_PATH . '/Session.php';
require_once CORE_PATH . '/CSRF.php';
require_once CORE_PATH . '/Request.php';
require_once CORE_PATH . '/Response.php';
require_once CORE_PATH . '/Bootstrap.php';
require_once CORE_PATH . '/Auth.php';
require_once CORE_PATH . '/View.php';
require_once CORE_PATH . '/Validator.php';
require_once CORE_PATH . '/FileUpload.php';
require_once CORE_PATH . '/RateLimiter.php';
require_once CORE_PATH . '/ContactIpLimiter.php';
require_once CORE_PATH . '/Router.php';
require_once CORE_PATH . '/App.php';

Session::start();
$app = new App();
$app->run();
