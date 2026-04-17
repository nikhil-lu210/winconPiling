<?php

declare(strict_types=1);

namespace Admin;

final class AuthController extends \BaseController
{
    public function loginPage(): void
    {
        $this->response->html(
            '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Admin login</title></head><body>'
            . '<h1>Admin login</h1><p>Phase 1 scaffold.</p></body></html>'
        );
    }

    public function login(): void
    {
        $this->response->redirect(\base_url('admin/dashboard'));
    }

    public function logout(): void
    {
        $this->response->redirect(\base_url('admin'));
    }
}
