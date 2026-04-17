<?php

declare(strict_types=1);

abstract class BaseController
{
    protected View $view;
    protected Request $request;
    protected Response $response;

    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
    }

    protected function render(string $viewName, array $data = [], string $layout = 'main'): void
    {
        $this->view->render($viewName, $data, $layout);
    }

    protected function redirect(string $url): never
    {
        $this->response->redirect($url);
    }

    /**
     * @param mixed $data
     */
    protected function jsonResponse(mixed $data, int $code = 200): never
    {
        $this->response->json($data, $code);
    }

    protected function abort(int $code): never
    {
        $this->response->abort($code);
    }

    /**
     * @return array<string, string|null>
     */
    protected function siteSettings(): array
    {
        return (new SiteSettingModel())->getAll();
    }
}
