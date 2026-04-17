<?php

declare(strict_types=1);

final class App
{
    public function run(): void
    {
        $this->registerAutoload();

        $request = new Request();
        /** @var array<int, array{0: string, 1: string, 2: string, 3: string}> $routes */
        $routes = require CONFIG_PATH . '/routes.php';

        $router = new Router();
        foreach ($routes as $row) {
            $router->addRoute($row[0], $row[1], $row[2], $row[3]);
        }

        if ($request->isPost()) {
            CSRF::verifyRequest();
        }

        $router->dispatch($request);
    }

    private function registerAutoload(): void
    {
        spl_autoload_register(static function (string $class): void {
            if (str_starts_with($class, 'Admin\\')) {
                $short = substr($class, strlen('Admin\\'));
                $path = APP_PATH . '/Controllers/Admin/' . str_replace('\\', '/', $short) . '.php';
            } else {
                $path = APP_PATH . '/Controllers/' . str_replace('\\', '/', $class) . '.php';
            }
            if (is_file($path)) {
                require_once $path;
            }
        });
    }
}
