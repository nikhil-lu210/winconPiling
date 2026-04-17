<?php

declare(strict_types=1);

final class View
{
    private string $viewsPath;

    public function __construct()
    {
        $this->viewsPath = APP_PATH . '/Views/';
    }

    public function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data, EXTR_SKIP);
        $viewFile = $this->viewsPath . str_replace('.', '/', $view) . '.php';
        if (!is_file($viewFile)) {
            $response = new Response();
            $response->abort(500, 'View not found: ' . $view);
        }
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        $layoutFile = $this->viewsPath . 'layouts/' . $layout . '.php';
        if (!is_file($layoutFile)) {
            $response = new Response();
            $response->abort(500, 'Layout not found: ' . $layout);
        }
        include $layoutFile;
    }

    public function partial(string $partial, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $file = $this->viewsPath . 'partials/' . $partial . '.php';
        if (is_file($file)) {
            include $file;
        }
    }
}
