<?php

declare(strict_types=1);

namespace Admin;

abstract class AdminBaseController extends \BaseController
{
    protected \SiteSettingModel $settings;
    protected int $unreadMessages;

    public function __construct()
    {
        parent::__construct();
        \Auth::guard();
        $this->settings = new \SiteSettingModel();
        $msgModel = new \MessageModel();
        $this->unreadMessages = $msgModel->countUnread();
    }

    protected function render(string $viewName, array $data = [], string $layout = 'admin'): void
    {
        $data['unreadMessages'] = $this->unreadMessages;
        $data['adminUser'] = \Auth::user();
        $data['settings'] = $this->settings->getAll();
        parent::render($viewName, $data, $layout);
    }

    protected function redirectBack(string $fallbackUrl): never
    {
        $ref = $this->request->header('Referer') ?? '';
        $base = rtrim((string) APP_URL, '/');
        if ($ref !== '' && str_starts_with($ref, $base)) {
            $this->response->redirect($ref);
        }
        $this->response->redirect($fallbackUrl);
    }
}
